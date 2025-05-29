<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Services\UserService;
use Modules\User\Data\UserData;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Response\WithResponse;

class AuthController
{
    use WithResponse;
    /**
     * Register a new user.
     */
    public function store(CreateUserRequest $request)
    {
        $userData = UserData::from([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => $request->input("password"),
        ]);

        UserService::createWithAttributes($userData);

        return $this->registerResponse();
    }

    /**
     * Authenticate user and generate token.
     */
    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        $userData = UserData::from($validated);

        $token = UserService::createToken($userData);

        if ($token) {
            return $this->loginResponse($token);
        }

        return $this->validationError(
            "The provided credentials are incorrect."
        );
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        UserService::clearToken($request);

        return $this->success("Successfully logged out.");
    }
}
