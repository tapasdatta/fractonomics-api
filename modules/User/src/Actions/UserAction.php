<?php
namespace Modules\User\Actions;

use Illuminate\Support\Str;
use Modules\User\Events\UserCreated;

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
        $attributes["uuid"] = (string) Str::uuid()->toString();

        event(new UserCreated($attributes));
    }
}
