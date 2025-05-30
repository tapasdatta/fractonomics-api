<?php

namespace Modules\Asset\Projectors;

use Illuminate\Support\Facades\Log;
use Modules\Asset\Models\Asset;
use Modules\Asset\Events\AssetCreated;
use Modules\Asset\Events\AssetStatusUpdated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AssetProjector extends Projector
{
    public function onAssetCreated(AssetCreated $event): void
    {
        Log::info("projector got called");
        $asset = new Asset($event->assetAttributes);

        $asset->writeable()->save();
    }

    public function onAssetStatusUpdated(AssetStatusUpdated $event): void
    {
        $asset = Asset::where("uuid", $event->assetUuid)->first();

        if ($asset) {
            $asset = $asset->writeable(); // Make the model writeable

            $asset->status = $event->newStatus;
            $asset->save();
        }
    }

    public function resetState(): void
    {
        Asset::query()->delete();
    }
}
