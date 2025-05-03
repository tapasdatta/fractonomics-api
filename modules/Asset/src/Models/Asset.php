<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Asset\Database\Factories\AssetFactory;
use Modules\User\Models\User;
use Modules\Asset\Enums\AssetStatus;
use Modules\Asset\Enums\Currency;

class Asset extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
