<?php
namespace Modules\User\Actions;

use Illuminate\Support\Facades\Hash;

use Modules\User\Models\User;

class AuthenticateUser
{
    /**
     * Handle the authentication of a user.
     *
     * @param  array  $attributes
     * @return string
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(array $attributes)
    {
        $user = $this->getUserByEmail($attributes["email"]);
        if ($user && Hash::check($attributes["password"], $user->password)) {
            return $user->createToken("auth_token")->plainTextToken;
        }
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
