<?php
namespace Modules\Asset\States;

class Active extends AssetState
{
    public function changesAllowed(): bool
    {
        return true;
    }

    public function nextState(): AssetState
    {
        return new Matured();
    }
}
