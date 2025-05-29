<?php
namespace Modules\User\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Illuminate\Support\Str;

class UserData extends Data
{
    public function __construct(
        public string|null $uuid = null,
        public string|Optional $name,
        public string $email,
        public string|Optional $password
    ) {}

    public function withUuid(): self
    {
        $this->uuid = (string) Str::uuid();
        return $this;
    }
}
