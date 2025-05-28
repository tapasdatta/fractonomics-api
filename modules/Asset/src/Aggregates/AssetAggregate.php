<?php
namespace Modules\Asset\Aggregates;

use Illuminate\Validation\ValidationException;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Events\AssetCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AssetAggregate extends AggregateRoot
{
    public $pendingCount = 0;

    public function createAsset(string $assetUuid, array $attributes)
    {
        if ($this->pendingCount >= 3) {
            throw ValidationException::withMessages([
                "asset_limit" =>
                    "You cannot create more than 3 pending assets.",
            ]);
        }

        $this->recordThat(new AssetCreated($assetUuid, $attributes));

        return $this;
    }

    public function applyAssetCreated(AssetCreated $event): void
    {
        if (
            isset($event->assetAttributes["status"]) &&
            $event->assetAttributes["status"] == AssetStatus::PROPOSED->value
        ) {
            $this->pendingCount++;
        }
    }
}
