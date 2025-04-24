<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            //sanctum token generation
        }

        //return error
        return response()->json(
            [
                "message" => "Invalid credentials",
            ],
            401
        );
    }
}
