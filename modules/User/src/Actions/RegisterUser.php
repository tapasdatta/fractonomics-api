<?php
namespace Modules\User\Actions;

use Modules\User\Models\User;

class RegisterUser
{
    /**
     * Handle the registration of a user.
     *
     * @param  array  $attributes
     * @return void
     */
    public function handle(array $attributes): void
    {
        User::create($attributes);

        //fire event and other stuffs
    }
}
