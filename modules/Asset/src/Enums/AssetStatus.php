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

    public function transitionTo(): string
    {
        $status = match ($this->value) {
            AssetStatus::PROPOSED => "voting",
            AssetStatus::VOTING => "funding",
            AssetStatus::FUNDING => "active",
            AssetStatus::ACTIVE => "matured",
            AssetStatus::MATURED => "",
        };

        return $status;
    }

    public static function transitions(): array
    {
        return [
            self::PROPOSED => self::VOTING,
            self::VOTING => self::FUNDING,
            self::FUNDING => self::ACTIVE,
            self::ACTIVE => self::MATURED,
        ];
    }

    public function canTransitionTo(self $newStatus): bool
    {
        $validTransitions = self::transitions();

        return ($validTransitions[$this] ?? null) === $newStatus;
    }
}
