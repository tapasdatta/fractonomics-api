<?php

namespace Modules\Asset\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Modules\Asset\Projectors\AssetProjector;
use Spatie\EventSourcing\Facades\Projectionist;

class EventServiceProvider extends BaseEventServiceProvider
{
    public function register()
    {
        Projectionist::addProjectors([AssetProjector::class]);
    }
}
