<?php
namespace Modules\Asset\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class AssetState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Proposed::class)
            ->allowTransition(Proposed::class, Voting::class)
            ->allowTransition(Voting::class, Funding::class)
            ->allowTransition(Funding::class, Active::class)
            ->allowTransition(Active::class, Matured::class);
    }
}
