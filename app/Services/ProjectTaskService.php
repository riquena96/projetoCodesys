<?php


namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use \CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use \Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ClientService
 *
 * @author henri
 */
class ProjectTaskService {

    /**
     * @var ProjectTaskValidator
     */
    protected $validator;

    /**
     * @var ProjectTaskRepository
     */
    protected $repository;

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    public function __construct(ProjectTaskRepository $repository,
                                ProjectRepository $projectRepository,
                                ProjectTaskValidator $validator) {
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->validator = $validator;
    }

    public function create(array $data) {

        try {
            $this->validator->with($data)->passesOrFail();

            $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
            $projectTask = $project->tasks()->create($data);

            return $projectTask;
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function update(array $data, $id)
    {
        try{
            $this->validator->with($data)->passesOrFail();

            return $this->repository->update($data, $id);

        } catch(ModelNotFoundException $e){
            return[
                'error' => true,
                'message' => $e->getMessage()
            ];
        } catch(ValidatorException $e){
            return[
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function delete($id)
    {
        $projectTask = $this->repository->skipPresenter()->find($id);
        return $projectTask->delete();
    }

}
