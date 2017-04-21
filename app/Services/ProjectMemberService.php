<?php

namespace CodeProject\Services;

use \CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectMemberValidator;
use \Prettus\Validator\Exceptions\ValidatorException;

class ProjectMemberService {


    /**
     * @var ProjectMemberValidator
     */
    protected $validator;

    /**
     * @var ProjectMemberRepository
     */
    protected $repository;

    public function __construct(ProjectMemberRepository $repository, ProjectMemberValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data) {

        try {
            $this->validator->with($data)->passesOrFail();

            return $this->repository->create($data);

        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function delete($id)
    {
        try{
            $projectMember = $this->repository->skipPresenter()->find($id);

            return $projectMember->delete();

        }catch(\Exception $e){
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
    
}
