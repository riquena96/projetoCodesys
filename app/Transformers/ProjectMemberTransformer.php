<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectMember;
use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract 
{

    protected $defaultIncludes = [
        'user'
    ];
    
    public function transform(ProjectMember $member)
    {
        return [
            'id' => $member->id,
            'project_id' => $member->project_id,
        ];
    }

    public function includeUser(ProjectMember $member)
    {
        return $this->item($member->member, new MemberTransformer());
    }
    
}
