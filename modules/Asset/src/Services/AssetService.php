<?php
namespace Modules\Asset\Services;

use Modules\Asset\Aggregates\AssetAggregate;
use Modules\Asset\Data\AssetData;
use Modules\Asset\Models\Asset;

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

    /**
     * Handle the registration of a user.
     *
     * @param  AssetData  $attributes
     * @return bool
     */
    public static function updateAssetStatus(Asset $asset, string $status): bool
    {
        $aggregate = AssetAggregate::retrieve($asset->user_uuid);

        $aggregate->updateAssetStatus($asset->uuid, $status)->persist();

        return true;
    }
}
