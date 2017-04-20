<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectFileRepository;
use \CodeProject\Services\ProjectFileService;

class ProjectFileController extends Controller {

    /**
     * @var ProjectFileService
     */
    private $service;

    /**
     * @var ProjectFileRepository
     */
    private $repository;

    public function __construct(ProjectFileRepository $repository, ProjectFileService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
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

    public function showFile($projectId, $id) {

        $filePath = $this->service->getFilePath($id);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);
        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($id),
        ];
    }

    public function destroy($id, $projectId)
    {

        if($this->repository->skipPresenter()->find($projectId)->delete()){
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
