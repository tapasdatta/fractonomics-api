<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Actions\AuthenticateUser;
use Modules\User\Actions\RegisterUser;
use Modules\User\Http\Requests\CreateUserRequest;
use Illuminate\Validation\ValidationException;
use Modules\User\Response\WithResponse;

class AuthController
{
    use WithResponse;

    /**
     * Register a new user in the system.
     *
     * @param CreateUserRequest $request Validated request containing user registration data
     * @param RegisterUser $register Service to handle user registration
     * @return mixed Registration response
     */
    public function store(CreateUserRequest $request, RegisterUser $register)
    {
        $register->handle($request->validated());

        return $this->registerResponse();
    }

    /**
     * Authenticate a user and generate access token.
     *
     * @param Request $request HTTP request containing user credentials
     * @param AuthenticateUser $login Service to handle user authentication
     * @return mixed Login response with authentication token
     * @throws ValidationException When provided credentials are incorrect
     */
    public function authenticate(Request $request, AuthenticateUser $login)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        $token = $login->handle($credentials);

        if (!$token) {
            throw ValidationException::withMessages([
                "email" => ["The provided credentials are incorrect."],
            ]);
        }

        return $this->loginResponse($token);
    }
}
