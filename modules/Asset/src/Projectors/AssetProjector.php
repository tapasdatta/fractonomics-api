<?php

namespace Modules\Asset\Projectors;

use Illuminate\Support\Facades\Log;
use Modules\Asset\Models\Asset;
use Modules\Asset\Events\AssetCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AssetProjector extends Projector
{
    public function onAssetCreated(AssetCreated $event): void
    {
        Log::info("User UUID: ", [$event->aggregateRootUuid()]);

        $asset = new Asset($event->assetAttributes);

        $asset->writeable()->save();
    }

    public function resetState(): void
    {
        Asset::query()->delete();
    }
}
