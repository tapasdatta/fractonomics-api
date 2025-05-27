<?php
namespace Modules\Asset\Actions;

use Modules\Asset\Events\AssetCreated;
use Illuminate\Support\Str;

class AssetAction
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
        $attributes["uuid"] = Str::uuid()->toString();

        event(new AssetCreated($attributes["uuid"], $attributes));
    }
}
