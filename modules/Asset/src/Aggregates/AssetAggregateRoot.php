<?php
namespace Modules\Asset\Aggregates;

use Modules\Asset\Data\CreateAssetData;
use Modules\Asset\Data\UpdateAssetStatusData;
use Modules\Asset\Events\AssetCreated;
use Modules\Asset\Events\AssetStatusUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AssetAggregateRoot extends AggregateRoot
{
    public function createAsset(string $assetUuid, CreateAssetData $attributes)
    {
        $this->recordThat(new AssetCreated($assetUuid, $attributes->toArray()));

        return $this;
    }

    public function updateAssetStatus(
        string $assetUuid,
        UpdateAssetStatusData $assetData
    ) {
        $this->recordThat(
            new AssetStatusUpdated($assetUuid, $assetData->toArray())
        );

        return $this;
    }
}
