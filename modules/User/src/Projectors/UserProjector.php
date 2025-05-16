<?php

namespace Modules\User\Projectors;

use Modules\User\Events\UserCreated;
use Modules\User\Models\User;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserProjector extends Projector
{
    public function onUserCreated(UserCreated $event)
    {
        (new User($event->userAttributes))->writeable()->save();
    }
}
