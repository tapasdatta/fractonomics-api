<?php
namespace Modules\Asset\Reactors;

use Illuminate\Support\Facades\Log;
use Modules\Asset\Events\AssetCreated;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class AssetReactor extends Reactor
{
    public function onAssetCreated(AssetCreated $event)
    {
        Log::info($event->assetAttributes);
    }
}
