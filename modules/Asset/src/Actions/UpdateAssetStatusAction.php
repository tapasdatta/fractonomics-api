<?php
namespace Modules\Asset\Actions;

use Modules\Asset\Aggregates\AssetAggregateRoot;
use Modules\Asset\Data\AssetData;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Models\Asset;

class UpdateAssetStatusAction
{
    /**
     * Handle the registration of a user.
     *
     * @param  AssetData  $attributes
     * @return bool
     */
    public static function execute(Asset $asset, AssetStatus $status)
    {
        AssetAggregateRoot::retrieve($asset->uuid)
            ->updateAssetStatus($asset->uuid, $status)
            ->persist();

        return true;
    }
}
