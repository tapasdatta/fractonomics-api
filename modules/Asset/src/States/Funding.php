<?php
namespace Modules\Asset\States;

class Funding extends AssetState
{
    public function changesAllowed(): bool
    {
        return true;
    }

    public function nextState(): AssetState
    {
        return new Active();
    }
}
