<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use \CodeProject\Repositories\ClientRepository;
use CodeProject\Repositories\UserRepository;
use CodeProject\Validators\ClientValidator;
use CodeProject\Validators\UserValidator;
use \Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ClientService
 *
 * @author henri
 */
class UserService {

    /**
     * @var ClientValidator
     */
    protected $validator;

    /**
     * @var ClientRepository
     */
    protected $repository;

    public function __construct(UserRepository $repository, UserValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data) {
        static $password;
        try {
            $this->validator->with($data)->passesOrFail();

            $token = str_random(10);
            $perfil = '1';

            $usuario = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                //'remember_token' => $token,
                'perfil' => $perfil
            ];

            return $this->repository->create($usuario);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function update(array $data, $id) {

        try {
            $this->validator->with($data)->passesOrFail();

            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

}
