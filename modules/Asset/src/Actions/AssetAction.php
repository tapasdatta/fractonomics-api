<?php
namespace Modules\Asset\Actions;

use Modules\Asset\Events\AssetCreated;

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
        event(new AssetCreated($attributes));
    }
}
