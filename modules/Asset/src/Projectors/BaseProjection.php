<?php
namespace Modules\Asset\Projectors;

use Spatie\EventSourcing\Projections\Projection;

class BaseProjection extends Projection
{
    public function getKeyName()
    {
        return "id";
    }
}
