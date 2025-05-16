<?php

use Illuminate\Routing\Middleware\ThrottleRequests;
use function Pest\Faker\fake;

beforeEach(function () {
    $this->withoutMiddleware(ThrottleRequests::class);
});

it("successfully logs in with valid credentials", function () {
    $user = user();

    $response = $this->postJson("/api/users/sanctum/token", [
        "email" => $user->email,
        "password" => "password",
    ]);

    expect($response->status())->toBe(201);
    expect($response->json("status"))->toBe("success");
    expect($response->json("message"))->toBe(
        "Login token generated successfully"
    );
    expect($response->json("data"))->toHaveKey("token");
});

it("fails when the email is incorrect", function () {
    $response = $this->postJson("/api/users/sanctum/token", [
        "email" => fake()->unique()->safeEmail(),
        "password" => "password",
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("message"))->toBe(
        "The provided credentials are incorrect."
    );
    expect($response->json("errors.email"))->toContain(
        "The provided credentials are incorrect."
    );
});

it("fails when the password is incorrect", function () {
    $user = user();

    $response = $this->postJson("/api/users/sanctum/token", [
        "email" => $user->email,
        "password" => "incorrect-password",
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("message"))->toBe(
        "The provided credentials are incorrect."
    );
    expect($response->json("errors.email"))->toContain(
        "The provided credentials are incorrect."
    );
});

it("fails when email is not provided", function () {
    $response = $this->postJson("/api/users/sanctum/token", [
        "password" => fake()->password(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.email"))->not->toBeEmpty();
});

it("fails when password is not provided", function () {
    $response = $this->postJson("/api/users/sanctum/token", [
        "email" => fake()->unique()->safeEmail(),
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("errors.password"))->not->toBeEmpty();
});

it("fails when both email and password are incorrect", function () {
    $response = $this->postJson("/api/users/sanctum/token", [
        "email" => fake()->unique()->safeEmail(),
        "password" => "incorrect-password",
    ]);

    expect($response->status())->toBe(422);
    expect($response->json("message"))->toBe(
        "The provided credentials are incorrect."
    );
    expect($response->json("errors.email"))->toContain(
        "The provided credentials are incorrect."
    );
});
