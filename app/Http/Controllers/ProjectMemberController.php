<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectMemberRepository;
use \CodeProject\Services\ProjectMemberService;
use Illuminate\Support\Facades\DB;

class ProjectMemberController extends Controller {

    /**
     * @var ProjectMemberService
     */
    private $service;

    /**
     * @var ProjectMemberRepository
     */
    private $repository;

    public function __construct(ProjectMemberRepository $repository, ProjectRepository $projectRepository, ProjectMemberService $service) {
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->service = $service;
        $this->middleware('check.project.owner', ['except' => ['index', 'show']]);
        $this->middleware('check.project.permission', ['except' => ['store', 'destroy']]);
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id, ['excluido', '=', '0']]);
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        $membroInserido = $this->service->create($data);
        $projeto = $this->projectRepository->find($id);
        return $projeto;
    }

    public function show($id, $idProjectMember)
    {
        return $this->repository->find($idProjectMember);
    }

    public function destroy($id, $idProjectMember)
    {
        DB::select("CALL excluiMembroProjeto($idProjectMember)");
        return 200;
    }

}
