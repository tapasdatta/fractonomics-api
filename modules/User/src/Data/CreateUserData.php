<?php
namespace Modules\User\Data;

use Spatie\LaravelData\Data;

class CreateUserData extends Data
{
    public function __construct(
        public ?string $uuid = null,
        public string $name,
        public string $email,
        public string $password
    ) {}
}
