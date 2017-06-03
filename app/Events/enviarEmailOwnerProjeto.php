<?php

namespace CodeProject\Events;

use CodeProject\Entities\ProjectMember;
use CodeProject\Entities\User;
use CodeProject\Entities\UserRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\DB;

class enviarEmailOwnerProjeto
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    private $member;

    public function __construct(ProjectMember $member)
    {
        $this->member = $member;
    }

    public function getMembro()
    {

        $id = $this->member->member_id;
        return DB::select("select email from users where id = $id");
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        //return ['user.'.\Authorizer::getResourceOwnerId()];
    }
}
