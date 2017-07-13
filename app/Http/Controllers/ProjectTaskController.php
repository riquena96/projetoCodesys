<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectTaskRepository;
use \CodeProject\Services\ProjectTaskService;
use Illuminate\Support\Facades\DB;

class ProjectTaskController extends Controller
{

    /**
     * @var ProjectTaskService
     */
    private $service;

    /**
     * @var ProjectTaskRepository
     */
    private $repository;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        return $this->repository->skipPresenter()->findWhere(['project_id' => $id]);
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }

    public function show($id, $idTask)
    {
        return $this->repository->find($idTask);
    }

    public function destroy($id, $idTask)
    {
        $this->service->delete($idTask);
    }

    public function update(Request $request, $id, $idTask)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->update($data, $idTask);
    }

    public function updateStatus(Request $request, $id, $idTask)
    {
        return DB::select("update project_files set excluido = 1 where id = $idTask");
    }

}
