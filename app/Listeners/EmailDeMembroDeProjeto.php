<?php

namespace CodeProject\Listeners;

use CodeProject\Mail\enviarEmailMembro;
use CodeProject\Events\enviarEmailOwnerProjeto;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class EmailDeMembroDeProjeto
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  enviarEmailOwnerProjeto  $event
     * @return void
     */
    public function handle(enviarEmailOwnerProjeto $event)
    {
        $email = $event->getMembro();

        Mail::send(new enviarEmailMembro($email));
    }
}
