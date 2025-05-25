<?php

namespace Modules\Asset\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AssetCreated extends ShouldBeStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $assetAttributes;

    /**
     * Create a new event instance.
     */
    public function __construct(array $assetAttributes)
    {
        $this->assetAttributes = $assetAttributes;
    }
}
