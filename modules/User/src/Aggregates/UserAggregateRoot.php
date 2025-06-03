<?php
namespace Modules\User\Aggregates;

use Modules\User\Data\CreateUserData;
use Modules\User\Events\UserCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class UserAggregateRoot extends AggregateRoot
{
    public function createUser(string $userUuid, CreateUserData $userData)
    {
        $this->recordThat(new UserCreated($userUuid, $userData->toArray()));

        return $this;
    }
}
