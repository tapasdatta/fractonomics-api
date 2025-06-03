<?php
namespace Modules\User\Actions;

use Illuminate\Support\Str;
use Modules\User\Aggregates\UserAggregateRoot;
use Modules\User\Data\CreateUserData;

class CreateUserAction
{
    public static function execute(CreateUserData $userData): bool
    {
        $userData->uuid = (string) Str::uuid();

        UserAggregateRoot::retrieve($userData->uuid)
            ->createUser($userData->uuid, $userData)
            ->persist();

        return true;
    }
}
