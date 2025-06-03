<?php
namespace Modules\Asset\Http\Requests;

use Illuminate\Validation\Validator;
use Modules\Asset\Models\Asset;
use Modules\Asset\States\Proposed;

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

        return Asset::where("user_uuid", $user->uuid)
            ->whereState("state", Proposed::class)
            ->count() >= 3;
    }
}
