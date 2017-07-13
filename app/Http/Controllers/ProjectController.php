<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\ProjectMember;
use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectRepository;
use \CodeProject\Services\ProjectService;
use Illuminate\Support\Facades\DB;

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

    public function modelMembroProjeto()
    {
        return ProjectMember::class;
    }

    public function index(Request $request)
    {
        return $this->repository->findOwner(\Authorizer::getResourceOwnerId());

        /*$userId = \Authorizer::getResourceOwnerId();
        $membro = DB::table('project_members')
            ->select(DB::raw('id,
            (SELECT name FROM projects WHERE id = project_id), 
            (SELECT description FROM projects WHERE id = project_id),
            (SELECT progress FROM projects WHERE id = project_id),
            (SELECT due_date FROM projects WHERE id = project_id),
            (SELECT status FROM projects WHERE id = project_id) '))
            ->where('member_id', '=', $userId);

        $usuario = DB::table('projects')
            ->select(DB::raw('id, name,description,progress,due_date,status '))
            ->where('owner_id', '=', $userId);

        $resultado = $usuario->union($membro)->get();
        return $resultado;*/
    }

    public function listaProjetoPermissaoUsuario(Request $request)
    {
        $userId = \Authorizer::getResourceOwnerId();

        return DB::select("CALL projetosPermissaoFindAll($userId)");

    }


    public function store(Request $request) {
        return $this->service->create($request->all());
    }

    public function show($id) {

        if($this->service->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        return $this->repository->find($id);
        //return DB::select('CALL exibeProjetos('.$id.')');
    }

    public function destroy($id) {
        
        if($this->service->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        DB::select("update projetos set excluido = 1 where id = $id");
        return 200;
    }

    public function update(Request $request, $id) {
        
        if($this->service->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }
        
        return $this->service->update($request->all(), $id);
    }
}
