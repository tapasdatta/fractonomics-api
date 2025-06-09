<?php
namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Bus;
use Modules\Asset\QueryBuilders\AssetQueryBuilder;
use Modules\Asset\States\AssetState;
use Modules\Asset\States\Proposed;
use Spatie\EventSourcing\Projections\Projection;
use Spatie\ModelStates\HasStates;

class Asset extends Projection
{
    use HasFactory, HasStates;

    protected $fillable = [
        "uuid",
        "user_uuid",
        "title",
        "description",
        "initial_value",
        "target_funding",
        "currency",
        "state",
    ];

    protected function casts(): array
    {
        return [
            "funding_deadline" => "datetime",
            "maturity_date" => "datetime",
            "state" => AssetState::class,
            "initial_value" => "float",
            "target_funding" => "float",
            "current_value" => "float",
            "current_funding" => "float",
        ];
    }

    public function getKeyName(): string
    {
        return "uuid";
    }

    public function newEloquentBuilder($query): AssetQueryBuilder
    {
        return new AssetQueryBuilder($query);
    }

    public function isProposed()
    {
        return $this->state->equals(Proposed::class);
    }
}
