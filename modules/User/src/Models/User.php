<?php

namespace Modules\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Database\Factories\UserFactory;

// use Modules\User\Database\Factories\UserFactory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ["name", "email", "password"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    public static function createWithAttributes(array $attributes): self
    {
        // Create the user with the given attributes
        $user = self::create($attributes);

        return $user;
    }

    /**
     * Generate a new token for the user.
     *
     * @return string
     */
    public static function generateToken($attributes): string
    {
        $user = self::where("email", $attributes["email"])->first();

        if (!$user || !Hash::check($attributes["password"], $user->password)) {
            throw ValidationException::withMessages([
                "email" => ["The provided credentials are incorrect."],
            ]);
        }

        $token = $user->createToken("auth_token")->plainTextToken;

        return $token;
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
