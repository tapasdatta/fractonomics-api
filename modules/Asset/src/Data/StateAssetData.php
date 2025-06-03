<?php
namespace Modules\Asset\Data;

use Spatie\LaravelData\Data;

class StateAssetData extends Data
{
    public function __construct(public string $state) {}
}
