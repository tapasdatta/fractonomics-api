<?php
namespace Modules\Asset\Aggregates;

use Illuminate\Validation\ValidationException;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Events\AssetStatusUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregatePartial;

class AssetStatusPartial extends AggregatePartial
{
    protected ?AssetStatus $status = null;

    // public function updateAssetStatus(string $assetUuid, AssetStatus $newStatus)
    // {
    //     $currentStatus = $this->status ?? AssetStatus::PROPOSED;

    //     if (!$currentStatus->canTransitionTo($newStatus)) {
    //         throw ValidationException::withMessages([
    //             "status" => "Cannot change status from {$currentStatus->value} to {$newStatus->value}",
    //         ]);
    //     }

    //     $this->recordThat(
    //         new AssetStatusUpdated($assetUuid, $newStatus->value)
    //     );

    //     return $this;
    // }

    // protected function applyAssetStatusUpdated(AssetStatusUpdated $event)
    // {
    //     $this->status =
    //         AssetStatus::from($event->newStatus) ?? AssetStatus::PROPOSED;
    // }
}
