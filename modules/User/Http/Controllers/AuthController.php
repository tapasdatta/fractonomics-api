<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Models\User;

class AuthController
{
    /**
     * Store a new user.
     */
    public function store(CreateUserRequest $request)
    {
        $attributes = $request->validated();

        User::createWithAttributes($attributes);

        return response()->json(
            [
                "status" => "success",
                "message" => "User created successfully",
            ],
            201
        );
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        $token = User::generateToken($credentials);

        return response()->json(
            [
                "status" => "success",
                "token" => $token,
                "message" => "Login token generated successfully",
            ],
            201
        );
    }
}
