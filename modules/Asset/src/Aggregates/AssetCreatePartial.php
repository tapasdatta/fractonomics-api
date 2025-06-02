<?php
namespace Modules\Asset\Aggregates;

use Modules\Asset\Data\CreateAssetData;
use Modules\Asset\Events\AssetCreated;
use Spatie\EventSourcing\AggregateRoots\AggregatePartial;

class AssetCreatePartial extends AggregatePartial
{
    public function createAsset(string $assetUuid, CreateAssetData $attributes)
    {
        $this->recordThat(new AssetCreated($assetUuid, $attributes->toArray()));

        return $this;
    }
}
