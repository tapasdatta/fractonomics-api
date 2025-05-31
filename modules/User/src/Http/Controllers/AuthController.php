<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Data\LoginData;
use Modules\User\Services\UserService;
use Modules\User\Data\UserData;
use Modules\User\Response\WithResponse;

class AuthController
{
    use WithResponse;
    /**
     * Register a new user.
     */
    public function store(UserData $userData)
    {
        UserService::createWithAttributes($userData);

        return $this->registerResponse();
    }

    /**
     * Authenticate user and generate token.
     */
    public function authenticate(LoginData $credentials)
    {
        $token = UserService::createToken($credentials);

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
