<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\Client;


class ClientTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['projects'];

    public function transform(Client $client)
    {
        if (array($client->excluido == 0)) {
            return [
                'id' => $client->id,
                'name' => $client->name,
                'responsible' => $client->responsible,
                'email' => $client->email,
                'phone' => $client->phone,
                'address' => $client->address,
                'obs' => $client->obs,
                'created_at' => $client->created_at,
                'updated_at' => $client->updated_at,
                'excluido' => $client->excluido,
                'skype' => $client->skype,
                'twitter' => $client->twitter,
                'facebook' => $client->facebook,
                'googleplus' => $client->googleplus,
                'site' => $client->site
            ];
        }
    }

    public function includeProjects(Client $client)
    {
        $transformer = new ProjectTransformer();
        $transformer->setDefaultIncludes([]);
        return $this->collection($client->project, $transformer);
    }
}
