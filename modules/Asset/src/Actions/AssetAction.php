<?php
namespace Modules\Asset\Actions;

use Illuminate\Support\Str;
use Modules\Asset\Aggregates\AssetAggregate;

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

        AssetAggregate::retrieve($attributes["user_uuid"])
            ->createAsset($attributes["uuid"], $attributes)
            ->persist();
    }
}
