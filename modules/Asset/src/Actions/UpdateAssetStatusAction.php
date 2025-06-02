<?php
namespace Modules\Asset\Actions;

use Modules\Asset\Aggregates\AssetAggregateRoot;
use Modules\Asset\Data\AssetData;
use Modules\Asset\Data\UpdateAssetStatusData;

class UpdateAssetStatusAction
{
    /**
     * Handle the registration of a user.
     *
     * @param  AssetData  $attributes
     * @return bool
     */
    public static function execute(
        string $assetUuid,
        UpdateAssetStatusData $assetData
    ) {
        AssetAggregateRoot::retrieve($assetUuid)
            ->updateAssetStatus($assetUuid, $assetData)
            ->persist();

        return true;
    }
}
