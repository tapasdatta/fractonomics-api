<?php

namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Modules\User\Projectors\UserProjector;
use Spatie\EventSourcing\Facades\Projectionist;

class EventServiceProvider extends BaseEventServiceProvider
{
    public function register()
    {
        Projectionist::addProjectors([UserProjector::class]);
    }
}
