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

    public static function transitions(): array
    {
        return [
            self::PROPOSED->value => self::VOTING,
            self::VOTING->value => self::FUNDING,
            self::FUNDING->value => self::ACTIVE,
            self::ACTIVE->value => self::MATURED,
        ];
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $validTransitions = self::transitions();

        return ($validTransitions[$this->value] ?? null)?->value === $newStatus;
    }

}
