<?php
namespace Modules\User\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\User\Events\UserCreated;
use Modules\User\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAction
{
    /**
     * Handle the registration of a user.
     *
     * @param  array  $attributes
     * @return void
     */
    public function createWithAttributes(array $attributes): void
    {
        /*
         * Let's generate a uuid.
         */
        event(new UserCreated($attributes));
    }

    /**
     * Handle the authentication of a user.
     *
     * @param  array  $attributes
     * @return string
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createToken(array $attributes)
    {
        $user = $this->getUserByEmail($attributes["email"]);

        if ($user && Hash::check($attributes["password"], $user->password)) {
            //fire an event: UserLoggedIn

            return JWTAuth::fromUser($user);
        }
        return false;
    }

    public function clearToken($request)
    {
        //fire logged out event

        JWTAuth::invalidate(JWTAuth::getToken());
    }

    /**
     * Get the user by email.
     *
     * @param  string  $email
     * @return User|null
     */
    private function getUserByEmail(string $email): ?User
    {
        return User::where("email", $email)->first();
    }
}
