<?php
namespace Modules\Asset\Data;

use Modules\Asset\Enums\AssetStatus;
use Spatie\LaravelData\Data;

abstract class AssetDataAbstract extends Data
{
    public string $user_uuid;
    public string $title;
    public string $description;
    public float $initial_value;
    public float $target_funding;
    public AssetStatus $status;
}
