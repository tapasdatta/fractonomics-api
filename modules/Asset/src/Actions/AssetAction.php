<?php
namespace Modules\Asset\Actions;

use Illuminate\Support\Str;
use Modules\Asset\Aggregates\AssetAggregate;
use Modules\Asset\Enums\AssetStatus;

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

        // Set the default status if it's not explicitly set
        $attributes["status"] =
            $attributes["status"] ?? AssetStatus::PROPOSED->value;

        AssetAggregate::retrieve($attributes["user_uuid"])
            ->createAsset($attributes["uuid"], $attributes)
            ->persist();
    }
}
