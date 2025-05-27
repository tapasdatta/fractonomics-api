<?php

namespace Modules\Asset\Projectors;

use Modules\Asset\Models\Asset;
use Modules\Asset\Events\AssetCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AssetProjector extends Projector
{
    public function onAssetCreated(AssetCreated $event)
    {
        (new Asset($event->assetAttributes))->writeable()->save();
    }

    public function resetState(): void
    {
        Asset::query()->delete();
    }
}
