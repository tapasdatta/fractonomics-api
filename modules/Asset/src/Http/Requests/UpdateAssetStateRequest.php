<?php

namespace Modules\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Modules\Asset\States\AssetState;
use Spatie\ModelStates\Validation\ValidStateRule;

class UpdateAssetStateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can("update", $this->asset);
    }

    public function rules(): array
    {
        return [
            "state" => ["required", new ValidStateRule(AssetState::class)],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (!$this->asset->state->canTransitionTo($this->state)) {
                    $validator
                        ->errors()
                        ->add(
                            "state",
                            "You cannot transition to {$this->state} from {$this->asset->state}."
                        );
                }
            },
        ];
    }
}
