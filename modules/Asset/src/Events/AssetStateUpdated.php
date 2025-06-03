<?php
namespace Modules\Asset\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AssetStateUpdated extends ShouldBeStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $assetUuid,
        public array $assetAttributes
    ) {}
}
