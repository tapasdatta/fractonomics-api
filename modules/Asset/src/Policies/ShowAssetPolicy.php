<?php

namespace Modules\Asset\Policies;

use Modules\Asset\Models\Asset;
use Modules\User\Models\User;

class ShowAssetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Asset $asset): bool
    {
        return $user->uuid === $asset->user_uuid;
    }
}
