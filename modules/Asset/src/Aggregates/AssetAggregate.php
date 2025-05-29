<?php
namespace Modules\Asset\Aggregates;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\Asset\Data\AssetData;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Events\AssetCreated;
use Modules\Asset\Events\AssetStatusUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AssetAggregate extends AggregateRoot
{
    public $pendingCount = 0;

    protected string $status = AssetStatus::PROPOSED->value;

    protected array $allowedTransitions = [
        "proposed" => ["voting"],
        "voting" => ["funding"],
        "funding" => ["active"],
        "active" => ["matured"],
    ];

    public function createAsset(string $assetUuid, AssetData $attributes)
    {
        if ($this->pendingCount >= 3) {
            throw ValidationException::withMessages([
                "asset_limit" =>
                    "You cannot create more than 3 pending assets.",
            ]);
        }

        $this->recordThat(new AssetCreated($assetUuid, $attributes->toArray()));

        return $this;
    }

    public function applyAssetCreated(AssetCreated $event): void
    {
        $this->status = $event->assetAttributes["status"];

        if ($this->status === AssetStatus::PROPOSED->value) {
            $this->pendingCount++;
        }
    }

    public function updateAssetStatus(
        string $assetUuid,
        string $newStatus
    ): static {
        if (!$this->isValidTransition($this->status, $newStatus)) {
            throw ValidationException::withMessages([
                "status" => "Invalid status transition from {$this->status} to $newStatus.",
            ]);
        }

        $this->recordThat(new AssetStatusUpdated($assetUuid, $newStatus));

        return $this;
    }

    public function applyAssetStatusUpdated(AssetStatusUpdated $event): void
    {
        $this->status = $event->newStatus;
    }

    protected function isValidTransition(string $from, string $to): bool
    {
        $from = strtolower($from);
        $to = strtolower($to);

        return in_array($to, $this->allowedTransitions[$from] ?? []);
    }
}
