<?php
namespace Modules\Asset\States;

abstract class AssetState
{
    abstract public function changesAllowed(): bool;

    abstract public function nextState(): AssetState;
}
