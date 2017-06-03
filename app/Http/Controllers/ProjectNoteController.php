<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectNoteRepository;
use \CodeProject\Services\ProjectNoteService;

class ProjectNoteController extends Controller
{

    /**
     * @var ProjectNoteService
     */
    private $service;

    /**
     * @var ProjectNoteRepository
     */
    private $repository;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id], ['excluido', '=', '0']);
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }

    public function show($id, $noteId)
    {
        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        if(isset($result['data']) && count($result['data']) == 1){
            $result = [
                'data' => $result['data'][0]
            ];
        }
        return $result;
    }

    public function destroy($id, $noteId)
    {
        return DB::select("CALL excluiNotaProjeto($noteId)");
    }

    public function update(Request $request, $id, $noteId)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->update($data, $noteId);
    }

}
