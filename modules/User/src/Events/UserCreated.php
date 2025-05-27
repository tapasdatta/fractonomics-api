<?php

namespace Modules\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserCreated extends ShouldBeStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userAttributes;
    public $userUuid;

    /**
     * Create a new event instance.
     */
    public function __construct(string $userUuid, array $userAttributes)
    {
        $this->userUuid = $userUuid;
        $this->userAttributes = $userAttributes;
    }
}
