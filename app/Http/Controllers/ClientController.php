<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ClientRepository;
use \CodeProject\Services\ClientService;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientController extends Controller
{

    /**
     * @var ClientService
     */
    private $service;

    /**
     * @var ClientRepository
     */
    private $repository;

    public function __construct(ClientRepository $repository, ClientService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        //$limit = $request->query->get('limit', 9);
        return $this->repository->scopeQuery(function ($query) {
            return $query->select('clients.*')->where('excluido', '=', '0');
        })->paginate($limit = 9, $columns = array());

    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function destroy($id)
    {
        DB::select("update clients set excluido = 1 where id = $id");
        return response("", 204);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

}
