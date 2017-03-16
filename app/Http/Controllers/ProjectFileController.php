<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectRepository;
use \CodeProject\Services\ProjectService;
use \Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\File;

class ProjectFileController extends Controller {

    /**
     * @var ProjectService
     */
    private $service;

    /**
     * @var ProjectRepository
     */
    private $repository;

    public function __construct(ProjectRepository $repository, ProjectService $service) {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index() {
        return $this->repository->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
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
        
        $this->service->createFile($data);
        
    }

    public function show($id) {

        if($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        return $this->repository->find($id);
    }

    public function destroy($id) {
        
        if($this->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        
        return $this->repository->delete($id);
    }

    public function update(Request $request, $id) {
        
        if($this->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        
        return $this->service->update($request->all(), $id);
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
