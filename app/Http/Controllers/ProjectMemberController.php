<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectMemberRepository;
use \CodeProject\Services\ProjectMemberService;

class ProjectMemberController extends Controller {

    /**
     * @var ProjectMemberService
     */
    private $service;

    /**
     * @var ProjectMemberRepository
     */
    private $repository;

    public function __construct(ProjectMemberRepository $repository, ProjectMemberService $service) {
        $this->repository = $repository;
        $this->service = $service;
        $this->middleware('check.project.owner', ['except' => ['index', 'show']]);
        $this->middleware('check.project.permission', ['except' => ['store', 'destroy']]);
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }

    public function show($id, $idProjectMember)
    {
        return $this->repository->find($idProjectMember);
    }

    public function destroy($id, $idProjectMember)
    {
        $this->service->delete($idProjectMember);
    }

}
