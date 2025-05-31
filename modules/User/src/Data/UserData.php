<?php
namespace Modules\User\Data;

use Spatie\LaravelData\Data;
use Illuminate\Support\Str;

class UserData extends Data
{
    public function __construct(
        public ?string $uuid = null,
        public ?string $name,
        public string $email,
        public ?string $password
    ) {}

    public function withUuid(): self
    {
        $this->uuid = (string) Str::uuid();
        return $this;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public static function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:5|confirmed",
        ];
    }
}
