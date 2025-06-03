<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Response\WithResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController
{
    use WithResponse;

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->success("Successfully logged out.");
    }
}
