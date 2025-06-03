<?php

namespace Modules\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Asset\States\AssetState;
use Modules\Asset\States\Proposed;
use Spatie\ModelStates\Validation\ValidStateRule;

class CreateAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_uuid" => "required",
            "title" => "required|min:5|unique:assets,title",
            "description" => "required|min:5",
            "initial_value" => "required|gte:100|lte:1000",
            "target_funding" => "required|gte:100|lte:1000",
            "state" => ["required", new ValidStateRule(AssetState::class)],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "user_uuid" => $this->user()->uuid,
            "state" => Proposed::class,
        ]);
    }

    public function after(): array
    {
        return [new ValidateAssetLimit()];
    }
}
