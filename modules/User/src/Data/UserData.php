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
}
