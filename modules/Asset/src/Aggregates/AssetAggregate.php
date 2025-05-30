<?php
namespace Modules\Asset\Aggregates;

use Modules\Asset\Data\AssetData;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AssetAggregate extends AggregateRoot
{
    protected AssetCreatePartial $createAssetPartial;
    protected AssetStatusPartial $statusUpdatePartial;

    public function __construct()
    {
        $this->createAssetPartial = new AssetCreatePartial($this);
        $this->statusUpdatePartial = new AssetStatusPartial($this);
    }

    public function createAsset(string $assetUuid, AssetData $attributes)
    {
        $this->createAssetPartial->createAsset($assetUuid, $attributes);

        return $this;
    }

    public function updateAssetStatus(string $assetUuid, string $newStatus)
    {
        $this->statusUpdatePartial->updateAssetStatus($assetUuid, $newStatus);

        return $this;
    }
}
