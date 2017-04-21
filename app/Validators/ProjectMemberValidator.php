<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Validators;

use \Prettus\Validator\LaravelValidator;

/**
 * Description of ClientValidator
 *
 * @author henri
 */
class ProjectMemberValidator extends LaravelValidator
{
    
    protected $rules = [

        'project_id' => 'required',
        'member_id' => 'required',
    ];
    
}
