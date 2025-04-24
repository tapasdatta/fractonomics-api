<?php

namespace Modules\Asset\Enums;

enum AssetStatus: string
{
    case ACTIVE = "active";
    case PROPOSED = "proposed";
    case VOTING = "voting";
    case FUNDING = "funding";
    case MATURED = "matured";

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
