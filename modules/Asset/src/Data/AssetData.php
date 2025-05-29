<?php
namespace Modules\Asset\Data;

use Spatie\LaravelData\Data;
use Illuminate\Support\Str;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Enums\Currency;
use Spatie\LaravelData\Optional;

class AssetData extends Data
{
    public function __construct(
        public ?string $uuid = null,
        public string $user_uuid,
        public string $title,
        public string $description,
        public Currency|Optional $currency = Currency::USD,
        public float $initial_value,
        public float|Optional $current_value = 0.0,
        public float $target_funding,
        public float $current_funding = 0.0,
        public AssetStatus $status = AssetStatus::PROPOSED,
        public int $vote_count = 0,
        public float $risk_index = 5.0,
        public ?string $funding_deadline = null,
        public ?string $maturity_date = null
    ) {}

    public function withUuid(): self
    {
        $this->uuid = (string) Str::uuid();
        return $this;
    }

    public function withStatus(): self
    {
        $this->status = AssetStatus::PROPOSED;
        return $this;
    }
}
