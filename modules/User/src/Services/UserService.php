<?php
namespace Modules\User\Services;

use Illuminate\Support\Facades\Hash;
use Modules\User\Events\UserCreated;
use Modules\User\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\User\Data\UserData;

class UserService
{
    /**
     * Handle the registration of a user.
     *
     * @param UserData $attributes
     * @return void
     */
    public static function createWithAttributes(UserData $attributes): void
    {
        /*
         * Let's generate a uuid.
         */
        $attributes = $attributes->withUuid();

        event(new UserCreated($attributes->uuid, $attributes));
    }

    /**
     * Handle the authentication of a user.
     *
     * @param  UserData $attributes
     * @return string | bool
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function createToken(UserData $attributes)
    {
        $user = User::where("email", $attributes->email)->first();

        if ($user && Hash::check($attributes->password, $user->password)) {
            //fire an event: UserLoggedIn

            return JWTAuth::fromUser($user);
        }
        return false;
    }

    public static function clearToken($request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
