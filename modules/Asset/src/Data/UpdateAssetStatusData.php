<?php
namespace Modules\Asset\Data;

use Modules\Asset\Enums\AssetStatus;
use Spatie\LaravelData\Data;

class UpdateAssetStatusData extends Data
{
    public function __construct(
        public string $uuid,
        public string $user_uuid,
        public AssetStatus $status
    ) {}
}
