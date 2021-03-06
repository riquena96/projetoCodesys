<?php

namespace CodeProject\Repositories;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Entities\Project;
use CodeProject\Validators\ProjectValidator;
use \CodeProject\Presenters\ProjectPresenter;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function isOwner($projectId, $userId)
    {
        if(count($this->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId]))){
            return true;
        }
        
        return false;
    }
    
    public function hasMember($projectId, $memberId)
    {
        $project = $this->skipPresenter()->find($projectId);
        
        foreach($project->members as $member){
            if($member->id == $memberId){
                return true;
            }
        }
        
        return false;
    }

    public function findOwner($userId, $limit = 9, $columns = array())
    {
        return $this->scopeQuery(function($query) use($userId){
            return $query->select('projects.id', 'projects.owner_id', 'projects.client_id', 'projects.name', 'projects.description', 'projects.progress',
                'projects.status', 'projects.due_date', 'projects.created_at', 'projects.updated_at', 'projects.excluido')
                ->leftjoin('project_members', 'project_members.project_id', '=', 'projects.id')
                ->groupBy('projects.id', 'projects.owner_id', 'projects.client_id', 'projects.name', 'projects.description', 'projects.progress',
                    'projects.status', 'projects.due_date', 'projects.created_at', 'projects.updated_at', 'projects.excluido')
                ->where('project_members.member_id', '=', $userId)
                ->orWhere('projects.owner_id', '=', $userId)
                ->where('projects.excluido', '=', '0');
        })->paginate($limit, $columns);
    }

    public function findWithOwnerAndMember($userId)
    {
        return $this->scopeQuery(function($query) use($userId){
            return $query->select('projects.*')
                ->leftjoin('project_members', 'project_members.project_id', '=', 'project_id')
                ->where('project_members.member_id', '=', $userId)
                ->union($this->model->query()->getQuery()->where('owner_id', '=', $userId));
        })->all();
    }
    
    public function presenter() 
    {
        return ProjectPresenter::class; 
        
    }
}
