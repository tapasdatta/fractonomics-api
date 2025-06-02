<?php
namespace Modules\Asset\Http\Requests;

use Illuminate\Validation\Validator;
use Modules\Asset\Models\Asset;

class ValidateAssetLimit
{
    public function __invoke(Validator $validator)
    {
        if ($this->hasExceededProposedAssetLimit()) {
            $validator
                ->errors()
                ->add(
                    "asset_limit",
                    "You cannot create more than 3 pending assets."
                );
        }
    }

    protected function hasExceededProposedAssetLimit(): bool
    {
        $user = request()->user();

        return Asset::proposedAssets($user->uuid)->count() >= 3;
    }
}
