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
class ProjectTaskValidator extends LaravelValidator
{
    
    protected $rules = [

        'name' => 'required',
        'status' => 'required',
    ];
    
}
