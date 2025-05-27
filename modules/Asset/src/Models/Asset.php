<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Database\Factories\AssetFactory;
use Modules\User\Models\User;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Enums\Currency;
use Spatie\EventSourcing\Projections\Projection;

class Asset extends Projection
{
    use HasFactory, HasUuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "uuid",
        "user_uuid",
        "title",
        "description",
        "initial_value",
        "target_funding",
        "currency",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "funding_deadline" => "datetime",
            "maturity_date" => "datetime",
            "status" => AssetStatus::class,
            "initial_value" => "float",
            "target_funding" => "float",
            "current_value" => "float",
            "current_funding" => "float",
            "currency" => Currency::class,
        ];
    }

    public function getKeyName()
    {
        return "uuid";
    }

    /**
     * Get the user that owns the asset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): AssetFactory
    {
        return AssetFactory::new();
    }
}
