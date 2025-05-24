<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Actions\UserAction;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Response\WithResponse;

class AuthController
{
    use WithResponse;

    /**
     * Register a new user.
     */
    public function store(CreateUserRequest $request, UserAction $user)
    {
        $user->createWithAttributes($request->validated());
        return $this->registerResponse();
    }

    /**
     * Authenticate user and generate token.
     */
    public function authenticate(Request $request, UserAction $user)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if ($token = $user->createToken($credentials)) {
            return $this->loginResponse($token);
        }

        return $this->validationError(
            "The provided credentials are incorrect."
        );
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request, UserAction $user)
    {
        $user->clearToken($request);
        return $this->success("Successfully logged out.");
    }
}
