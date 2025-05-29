<?php

namespace Modules\User\Projectors;

use Modules\User\Events\UserCreated;
use Modules\User\Models\User;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserProjector extends Projector
{
    public function onUserCreated(UserCreated $event): void
    {
        $user = new User($event->userAttributes);

        $user->writeable()->save();
    }
}
