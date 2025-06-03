<?php

namespace Modules\Asset\Projectors;

use Modules\Asset\Models\Asset;
use Modules\Asset\Events\AssetCreated;
use Modules\Asset\Events\AssetStateUpdated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AssetProjector extends Projector
{
    public function onAssetCreated(AssetCreated $event): void
    {
        $asset = new Asset($event->assetAttributes);

        $asset->writeable()->save();
    }

    public function onAssetStateUpdated(AssetStateUpdated $event): void
    {
        $asset = Asset::where("uuid", $event->assetUuid)->first();

        if ($asset) {
            $asset->state = $event->assetAttributes["state"];

            $asset->writeable()->save();
        }
    }

    public function resetState(): void
    {
        Asset::query()->delete();
    }
}
