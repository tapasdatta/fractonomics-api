<?php

namespace Modules\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Asset\Enums\Currency;

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
            "title" => "required|min:5|unique:assets,title",
            "description" => "required|min:5",
            "initial_value" => "required|gte:100|lte:1000",
            "target_funding" => "required|gte:100|lte:1000",
            "currency" => ["required", Rule::enum(Currency::class)],
        ];
    }

    public function validated($keys = null, $default = null)
    {
        return array_merge(parent::validated($keys), [
            "user_id" => $this->user()?->id,
        ]);
    }
}
