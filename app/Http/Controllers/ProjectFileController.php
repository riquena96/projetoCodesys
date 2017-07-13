<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectFileRepository;
use \CodeProject\Services\ProjectFileService;
use Illuminate\Support\Facades\DB;

class ProjectFileController extends Controller {

    /**
     * @var ProjectFileService
     */
    private $service;

    /**
     * @var ProjectFileRepository
     */
    private $repository;

    /**
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    private $storage;

    public function __construct(ProjectFileRepository $repository, ProjectFileService $service, Factory $storage)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->storage = $storage;
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id], ['excluido', '=', '0']);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        
        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;
        
        $this->service->create($data);
        
    }

    public function show($id, $projectId)
    {
        return $this->repository->find($projectId);
    }

    public function showFile($projectId, $id)
    {

        $model = $this->repository->skipPresenter()->find($id);
        $filePath = $this->service->getFilePath($id);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);
        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($id),
            'mime_type' => $this->storage->mimeType($model->getFileName())
        ];
    }

    public function destroy($id, $projectId)
    {

        if(DB::select("update project_files set excluido = 1 where id = $projectId")){
            return ['success'=>true, 'message'=>'Arquivo '.$projectId.' excluído com sucesso!'];
        }
        return ['error'=>true, 'message'=>'Não foi possível excluir o arquivo '.$projectId];
        //return $this->repository->skipPresenter()->find($projectId)->delete();
    }

    public function update(Request $request, $id, $projectId)
    {
        
        return $this->service->update($request->all(), $projectId);
    }

    private function checkProjectOwner($projectId) {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId, $userId);
    }
    
    private function checkProjectMember($projectId) {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId, $userId);
    }
    
    private function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }
        return false;
    }

}
