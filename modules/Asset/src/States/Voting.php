<?php
namespace Modules\Asset\States;

class Voting extends AssetState
{
    public function changesAllowed(): bool
    {
        return true;
    }

    public function nextState(): AssetState
    {
        return new Funding();
    }
}
