<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Description of ClientValidator
 *
 * @author henri
 */
class ProjectFileValidator extends LaravelValidator
{
    
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png,pdf,zip',
            'description' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
            'description' => 'required',
        ]

    ];
    
}
