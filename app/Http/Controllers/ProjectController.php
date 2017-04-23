<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectRepository;
use \CodeProject\Services\ProjectService;

class ProjectController extends Controller {

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
        $this->middleware('check.project.owner', ['except' => ['index', 'store', 'show']]);
        $this->middleware('check.project.permission', ['except' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(Request $request) {
        return $this->repository
            ->findOwner(\Authorizer::getResourceOwnerId(), $request->query->get('limit'));
    }

    public function store(Request $request) {
        return $this->service->create($request->all());
    }

    public function show($id) {

        if($this->service->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        return $this->repository->find($id);
    }

    public function destroy($id) {
        
        if($this->service->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->delete($id);
    }

    public function update(Request $request, $id) {
        
        if($this->service->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        
        return $this->service->update($request->all(), $id);
    }
}
