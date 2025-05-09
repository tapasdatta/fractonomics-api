<?php

namespace Modules\Asset\Enums;

enum Currency: string
{
    case USD = "usd";

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
