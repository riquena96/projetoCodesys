<?php

namespace CodeProject\Services;

use \CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use \Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService {

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var FileSystem
     */
    private $filesystem;

    /**
     * @var ProjectValidator
     */
    protected $validator;

    /**
     * @var ProjectRepository
     */
    protected $repository;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, FileSystem $filesystem, Storage $storage) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
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
    
    public function createFile(array $data)
    {
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data);
        
        $this->storage->put($projectFile->id .".". $data['extension'], $this->filesystem->get($data['file']));        
    }
    
}
