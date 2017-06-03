<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    
    protected $fillable = [
        'name',
        'responsible',
        'email',
        'phone',
        'address',
        'obs',
        'excluido',
        'skype',
        'twitter',
        'facebook',
        'googleplus',
        'site'
    ];

    public function project(){
        return $this->hasMany(Project::class);
    }
    
}
