<?php

namespace CodeProject\Events;

use CodeProject\Entities\ProjectTask;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskWasIncluded extends SomeEvent implements ShouldBroadcast {

    use SerializesModels;

    public $task;

    public function __construct(ProjectTask $task)
    {
        $this->task = $task;
    }

    public function broadcastOn()
    {
        return ['user.'.\Authorizer::getResourceOwnerId()];
    }

}