<?php
namespace Modules\Asset\Actions;

use Modules\Asset\Aggregates\AssetAggregateRoot;
use Modules\Asset\Data\AssetData;
use Modules\Asset\Data\StateAssetData;

class UpdateAssetStateAction
{
    /**
     * Handle the registration of a user.
     *
     * @param  AssetData  $attributes
     * @return bool
     */
    public static function execute(string $assetUuid, StateAssetData $assetData)
    {
        AssetAggregateRoot::retrieve($assetUuid)
            ->updateAssetState($assetUuid, $assetData)
            ->persist();

        return true;
    }
}
