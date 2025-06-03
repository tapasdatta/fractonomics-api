<?php
namespace Modules\Asset\Aggregates;

use Modules\Asset\Data\CreateAssetData;
use Modules\Asset\Data\StateAssetData;
use Modules\Asset\Events\AssetCreated;
use Modules\Asset\Events\AssetStateUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AssetAggregateRoot extends AggregateRoot
{
    public function createAsset(string $assetUuid, CreateAssetData $attributes)
    {
        $this->recordThat(new AssetCreated($assetUuid, $attributes->toArray()));

        return $this;
    }

    public function updateAssetState(
        string $assetUuid,
        StateAssetData $assetData
    ) {
        $this->recordThat(
            new AssetStateUpdated($assetUuid, $assetData->toArray())
        );

        return $this;
    }
}
