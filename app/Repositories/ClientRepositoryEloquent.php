<?php

namespace CodeProject\Repositories;

use CodeProject\Presenters\ClientPresenter;
use \Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use \CodeProject\Entities\Client;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{

    protected $fieldSearchable = [
        'name'
    ];

    public function model() 
    {
        return Client::class;
        
    }

    public function presenter()
    {
        return ClientPresenter::class;
    }

    public function boot(){
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

}
