<?php
namespace Modules\Asset\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Asset\Database\Factories\AssetFactory;
use Modules\User\Models\User;

class AssetQueryBuilder extends Builder
{
    protected static function newFactory(): AssetFactory
    {
        return AssetFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
