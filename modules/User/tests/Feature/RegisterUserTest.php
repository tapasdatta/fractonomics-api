<?php

use Modules\User\Models\User;
use function Pest\Faker\fake;

beforeEach(function () {
    // Setup tasks if needed
});

it("registers a new user successfully", function () {
    $email = fake()->unique()->safeEmail();
    $password = fake()->password();

    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => $email,
        "password" => $password,
        "password_confirmation" => $password,
    ]);

    expect($response->status())->toBe(201);
    expect(User::where("email", $email)->exists())->toBeTrue();
});

it("fails when the email is already taken", function () {
    $existingUser = User::factory()->create();

    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => $existingUser->email,
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.email"))->not->toBeEmpty();
});

it("fails when password and password_confirmation do not match", function () {
    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.password"))->not->toBeEmpty();
});

it("fails when email is not provided", function () {
    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.email"))->not->toBeEmpty();
});

it("fails when name is not provided", function () {
    $response = $this->postJson("/api/users/register", [
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.name"))->not->toBeEmpty();
});

it("fails when password is not provided", function () {
    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password_confirmation" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.password"))->not->toBeEmpty();
});

it("fails when password is too short", function () {
    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => "123",
        "password_confirmation" => "123",
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.password"))->not->toBeEmpty();
});

it("fails when invalid email format is provided", function () {
    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => "invalid-email-format",
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.email"))->not->toBeEmpty();
});

it("registers a new user with valid data", function () {
    $email = fake()->unique()->safeEmail();
    $password = fake()->password();

    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => $email,
        "password" => $password,
        "password_confirmation" => $password,
    ]);

    expect($response->status())->toBe(201);
    expect(User::where("email", $email)->exists())->toBeTrue();
});

it("fails if email is not a valid email address", function () {
    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => "invalid-email",
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.email"))->not->toBeEmpty();
});

it("fails if the password_confirmation is missing", function () {
    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.password"))->not->toBeEmpty();
});

it("returns validation error if email already exists", function () {
    $user = User::factory()->create();

    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => $user->email,
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.email"))->not->toBeEmpty();
});

it("fails if password is missing a confirmation", function () {
    $response = $this->postJson("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.password"))->not->toBeEmpty();
});
