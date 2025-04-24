<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;
use Modules\Asset\Enums\AssetStatus;

class Asset extends Model
{
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
            "initial_value" => "decimal:2",
            "target_funding" => "decimal:2",
            "current_value" => "decimal:2",
            "current_funding" => "decimal:2",
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
}
