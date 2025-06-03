<?php

namespace Modules\Asset\Policies;

use Modules\Asset\Models\Asset;
use Modules\User\Models\User;

class UpdateAssetStatePolicy
{
    /**
     * Determine if the given post can be updated by the user.
     */
    public function update(User $user, Asset $asset): bool
    {
        return $user->uuid === $asset->user_uuid;
    }
}
