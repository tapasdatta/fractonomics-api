<?php
namespace Modules\Asset\Data;

class ViewAssetData extends AssetDataAbstract
{
    public function __construct(
        public string $currency,
        public float $current_value,
        public float $current_funding,
        public int $vote_count,
        public ?string $funding_deadline,
        public ?string $maturity_date,
        public float $risk_index,
        public string $created_at,
        public string $updated_at
    ) {}
}
