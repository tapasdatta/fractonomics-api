<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Actions\CreateUserAction;
use Modules\User\Data\CreateUserData;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Response\WithResponse;

class CreateUserController
{
    use WithResponse;

    /**
     * Register a new user.
     */
    public function store(
        CreateUserRequest $request,
        CreateUserAction $createUserAction
    ) {
        $userData = CreateUserData::from($request->validated());

        $createUserAction->execute($userData);

        return $this->registerResponse();
    }
}
