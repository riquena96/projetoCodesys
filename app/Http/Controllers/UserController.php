<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\UserService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UserController extends Controller
{

    private $repository;

    public function __construct(UserRepository $repository, UserService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function authenticated(){
        $userId = Authorizer::getResourceOwnerId();
        return $this->repository->find($userId);
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

}
