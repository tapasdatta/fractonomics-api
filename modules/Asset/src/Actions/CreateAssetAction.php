<?php
namespace Modules\Asset\Actions;

use Modules\Asset\Aggregates\AssetAggregateRoot;
use Modules\Asset\Data\AssetData;
use Illuminate\Support\Str;
use Modules\Asset\Data\CreateAssetData;

class CreateAssetAction
{
    /**
     * Handle the registration of a user.
     *
     * @param  AssetData  $attributes
     * @return bool
     */
    public static function execute(CreateAssetData $assetData): bool
    {
        $uuid = (string) Str::uuid();

        AssetAggregateRoot::retrieve($uuid)
            ->createAsset($uuid, $assetData)
            ->persist();

        return true;
    }
}
