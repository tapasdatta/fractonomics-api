<?php
namespace Modules\Asset\Services;

use Modules\Asset\Aggregates\AssetAggregate;
use Modules\Asset\Data\AssetData;

class AssetService
{
    /**
     * Handle the registration of a user.
     *
     * @param  AssetData  $attributes
     * @return bool
     */
    public static function createWithAttributes(AssetData $attributes): bool
    {
        /*
         * Let's generate a uuid and set default status.
         */
        $attributes = $attributes->withUuid()->withStatus();

        $aggregate = AssetAggregate::retrieve($attributes->user_uuid);

        $aggregate->createAsset($attributes->uuid, $attributes)->persist();

        return true;
    }
}
