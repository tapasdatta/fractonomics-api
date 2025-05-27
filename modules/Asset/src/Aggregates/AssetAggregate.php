<?php
namespace Modules\Asset\Aggregates;

use Illuminate\Validation\ValidationException;
use Modules\Asset\Events\AssetCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AssetAggregate extends AggregateRoot
{
    public $assetCount = 0;

    public function createAsset(string $assetUuid, array $attributes)
    {
        if ($this->assetCount >= 3) {
            throw ValidationException::withMessages([
                "asset_limit" => "You cannot create more than 3 assets.",
            ]);
        }

        $this->recordThat(new AssetCreated($assetUuid, $attributes));

        return $this;
    }

    public function applyAssetCreated(AssetCreated $event): void
    {
        $this->assetCount++;
    }
}
