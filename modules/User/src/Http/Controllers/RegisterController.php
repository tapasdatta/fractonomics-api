<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Actions\UserAction;
use Modules\User\Http\Requests\CreateUserRequest;
use Illuminate\Validation\ValidationException;
use Modules\User\Response\WithResponse;

class RegisterController
{
    use WithResponse;

    /**
     * Register a new user in the system.
     *
     * @param CreateUserRequest $request Validated request containing user registration data
     * @param UserAction $user Service to handle user registration
     * @return mixed Registration response
     */
    public function store(CreateUserRequest $request, UserAction $user)
    {
        $user->createWithAttributes($request->validated());

        return $this->registerResponse();
    }

    /**
     * Authenticate a user and generate access token.
     *
     * @param Request $request HTTP request containing user credentials
     * @param UserAction $user Service to handle user authentication
     * @return mixed Login response with authentication token
     * @throws ValidationException When provided credentials are incorrect
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
