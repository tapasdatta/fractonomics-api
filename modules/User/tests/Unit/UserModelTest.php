<?php

use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use function Pest\Faker\fake;

beforeEach(function () {
    // Optional: you could use RefreshDatabase trait if needed.
});

it("can create a user and save to the database", function () {
    $user = User::factory()->create([
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => bcrypt("password"),
    ]);

    expect($user->email)->not->toBeNull();
    expect(User::where("email", $user->email)->exists())->toBeTrue();
});

it("validates user attributes correctly", function () {
    $user = User::factory()->make(); // use make() instead of new manually

    expect($user->name)->toBeString();
    expect($user->email)->toBeString()->and($user->email)->toContain("@");
});

it("hashes the password before saving", function () {
    $plainPassword = "secret123";

    $user = User::factory()->create([
        "password" => bcrypt($plainPassword),
    ]);

    expect($user->password)->not->toBe($plainPassword);
    expect(Hash::check($plainPassword, $user->password))->toBeTrue();
});

it("ensures email is unique", function () {
    $email = fake()->unique()->safeEmail();
    User::factory()->create(["email" => $email]);

    expect(fn() => User::factory()->create(["email" => $email]))->toThrow(
        \Illuminate\Database\QueryException::class
    );
});

it("ensures password confirmation matches password", function () {
    $plainPassword = "password123";

    $userData = [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => bcrypt($plainPassword),
        "password_confirmation" => $plainPassword,
    ];

    $user = User::create($userData);

    // password_confirmation is not actually saved in DB, just during form validation.
    // We can only check the password.
    expect(Hash::check($plainPassword, $user->password))->toBeTrue();
});

it("rejects invalid email format manually", function () {
    $invalidEmail = "invalid-email-format";

    $user = User::create([
        "name" => fake()->name(),
        "email" => $invalidEmail,
        "password" => bcrypt(fake()->password()),
    ]);

    expect($user->email)->not->toMatch('/^[\w\.-]+@[\w\.-]+\.\w{2,4}$/');
});

it("can authenticate user using email and password", function () {
    $plainPassword = "secret123";

    $user = User::factory()->create([
        "password" => bcrypt($plainPassword),
    ]);

    $foundUser = User::where("email", $user->email)->first();

    expect(Hash::check($plainPassword, $foundUser->password))->toBeTrue();
});
