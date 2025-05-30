<?php
namespace Modules\Asset\Aggregates;

use Illuminate\Validation\ValidationException;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Events\AssetStatusUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregatePartial;

class AssetStatusPartial extends AggregatePartial
{
    protected string $status = AssetStatus::PROPOSED->value;

    protected array $allowedTransitions = [
        "proposed" => ["voting"],
        "voting" => ["funding"],
        "funding" => ["active"],
        "active" => ["matured"],
    ];

    public function updateAssetStatus(string $assetUuid, string $newStatus)
    {
        if (!$this->isValidTransition($this->status, $newStatus)) {
            throw ValidationException::withMessages([
                "status" => "Invalid status transition from {$this->status} to $newStatus.",
            ]);
        }

        $this->recordThat(new AssetStatusUpdated($assetUuid, $newStatus));

        return $this;
    }

    protected function applyAssetStatusUpdated(AssetStatusUpdated $event)
    {
        $this->status = $event->newStatus;
    }

    protected function isValidTransition(string $from, string $to)
    {
        $from = strtolower($from);
        $to = strtolower($to);

        return in_array($to, $this->allowedTransitions[$from] ?? []);
    }
}
