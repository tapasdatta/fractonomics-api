<?php
namespace Modules\Asset\Http\Requests;

use Illuminate\Validation\Validator;
use Modules\Asset\Models\Asset;

class ValidateAssetStateTransition
{
    public function __invoke(Validator $validator)
    {
        if ($this->hasExceededProposedAssetLimit()) {
            $validator
                ->errors()
                ->add(
                    "state",
                    "You cannot transition to {{request->input('state')}}"
                );
        }
    }

    protected function hasExceededProposedAssetLimit(): bool
    {
        $user = request()->user();

        return Asset::proposedAssets($user->uuid)->count() >= 3;
    }
}
