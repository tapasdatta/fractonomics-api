<?php
namespace Modules\User\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\User\Data\LoginUserData;
use Modules\User\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserAction
{
    public static function execute(LoginUserData $userData): string|false
    {
        $user = User::where("email", $userData->email)->first();

        if ($user && Hash::check($userData->password, $user->password)) {
            return JWTAuth::fromUser($user);
        }

        return false;
    }
}
