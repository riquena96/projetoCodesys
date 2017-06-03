<?php

namespace CodeProject\Providers;

use CodeProject\Entities\ProjectMember;
use CodeProject\Entities\ProjectTask;
use CodeProject\Events\enviarEmailOwnerProjeto;
use CodeProject\Events\TaskWasIncluded;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ProjectTask::created(function($task){
            Event::fire(new TaskWasIncluded($task));
        });

        ProjectTask::updated(function ($task) {
            Event::fire(new TaskWasIncluded($task));
        });

        ProjectMember::created(function($member) {
            Event::fire(new enviarEmailOwnerProjeto($member));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
