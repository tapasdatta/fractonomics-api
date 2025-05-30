<?php
namespace Modules\Asset\Aggregates;

use Illuminate\Validation\ValidationException;
use Modules\Asset\Data\AssetData;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Events\AssetCreated;
use Spatie\EventSourcing\AggregateRoots\AggregatePartial;

class AssetCreatePartial extends AggregatePartial
{
    protected $pendingCount = 0;

    public function createAsset(string $assetUuid, AssetData $attributes)
    {
        if ($this->pendingCount >= 3) {
            throw ValidationException::withMessages([
                "asset_limit" =>
                    "You cannot create more than 3 pending assets.",
            ]);
        }

        $this->recordThat(new AssetCreated($assetUuid, $attributes->toArray()));

        return $this;
    }

    protected function applyAssetCreated(AssetCreated $event)
    {
        if ($event->assetAttributes["status"] == AssetStatus::PROPOSED->value) {
            $this->pendingCount++;
        }
    }
}
