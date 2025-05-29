<?php

namespace Modules\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Data\UserData;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserCreated extends ShouldBeStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $userUuid;
    public UserData $userAttributes;

    public function __construct(string $userUuid, UserData $userAttributes)
    {
        $this->userUuid = $userUuid;
        $this->userAttributes = $userAttributes;
    }
}
