<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['members', 'notes', 'tasks', 'files', 'client'];


    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'client_id' => $project->client_id,
            'owner_id' => $project->owner_id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' =>(int) $project->progress,
            'status' =>  $this->statusNomeExibir($project),
            'due_date' => $project->due_date,
            'is_member' => $project->owner_id != \Authorizer::getResourceOwnerId(),
            'tasks_count' => $project->tasks->count(),
            'tasks_opened' => $this->countTasksOpened($project),
            'excluido' => $project->excluido
        ];
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new MemberTransformer());
    }

    public function includeNotes(Project $project)
    {
        return $this->collection($project->notes, new ProjectNoteTransformer());
    }

    public function includeFiles(Project $project)
    {
        return $this->collection($project->files, new ProjectFileTransformer());
    }

    public function includeTasks(Project $project)
    {
        return $this->collection($project->tasks, new ProjectTaskTransformer());
    }

    public function includeClient(Project $project)
    {
        //if($project->client) {
            return $this->item($project->client, new ClientTransformer());
        //}
        //return null;
    }

    public function statusNomeExibir(Project $project)
    {
        if ($project->status == 1) {
            return ['status' => 'Não iniciado', 'class' => 'text-gray'];
        } else if ($project->status == 2) {
            return ['status' => 'Iniciado', 'class' => 'text-info'];
        } else if ($project->status == 3){
            return ['status' => 'Concluído', 'class' => 'text-success'];
        }
    }

    public function countTasksOpened(Project $project)
    {
        $count = 0;
        foreach ($project->tasks as $o){
            if($o->status == 1){
                $count++;
            }
        }
        return $count;
    }


}
