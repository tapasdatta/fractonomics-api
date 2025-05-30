<?php
namespace Modules\Asset\States;

class Matured extends AssetState
{
    public function changesAllowed(): bool
    {
        return false;
    }

    public function nextState(): AssetState
    {
        return new Matured();
    }
}
