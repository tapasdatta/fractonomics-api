<?php
namespace Modules\Asset\States;

class Proposed extends AssetState
{
    public function changesAllowed(): bool
    {
        return true;
    }

    public function nextState(): AssetState
    {
        return new Voting();
    }
}
