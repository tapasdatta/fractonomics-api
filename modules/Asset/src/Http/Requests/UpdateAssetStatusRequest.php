<?php

namespace Modules\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Asset\Enums\AssetStatus;

class UpdateAssetStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can("update", $this->asset);
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
            "status" => ["required", Rule::enum(AssetStatus::class)],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "user_uuid" => $this->user()->uuid,
        ]);
    }

    // public function after(): array
    // {
    //     return [new ValidateAssetLimit()];
    // }
}
