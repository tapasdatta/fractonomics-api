<?php

use Modules\User\Models\User;
use function Pest\Faker\fake;

beforeEach(function () {
    // Optionally reset the database or perform setup tasks.
});

it("registers a new user successfully", function () {
    $email = fake()->unique()->safeEmail();
    $password = fake()->password();

    // Register the user
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => $email,
        "password" => $password,
        "password_confirmation" => $password,
    ]);

    // Check for successful status and user existence in the database
    $response->assertStatus(201);
    $this->assertDatabaseHas("users", [
        "email" => $email,
    ]);
});

it("fails when the email is already taken", function () {
    // Create a user in the database
    $existingUser = User::factory()->create();

    // Try to register another user with the same email
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => $existingUser->email, // Same email
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    // Assert that it fails due to the email already being taken
    $response->assertStatus(422); // Unprocessable Entity
    $response->assertJsonValidationErrors(["email"]);
});

it("fails when password and password_confirmation do not match", function () {
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(), // Mismatched confirmation
    ]);

    // Assert that it fails due to password mismatch
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["password"]);
});

it("fails when email is not provided", function () {
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    // Assert that the email is required
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["email"]);
});

it("fails when name is not provided", function () {
    $response = $this->post("/api/users/register", [
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    // Assert that the name is required
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["name"]);
});

it("fails when password is not provided", function () {
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password_confirmation" => fake()->password(),
    ]);

    // Assert that the password is required
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["password"]);
});

it("fails when password is too short", function () {
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => "123", // Too short
        "password_confirmation" => "123",
    ]);

    // Assert that the password is too short
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["password"]);
});

it("fails when invalid email format is provided", function () {
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => "invalid-email-format", // Invalid email format
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    // Assert that the email format is invalid
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["email"]);
});

it("registers a new user with valid data", function () {
    $email = fake()->unique()->safeEmail();
    $password = fake()->password();

    // Register the user with valid data
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => $email,
        "password" => $password,
        "password_confirmation" => $password,
    ]);

    // Assert successful registration and the user is in the database
    $response->assertStatus(201);
    $this->assertDatabaseHas("users", [
        "email" => $email,
    ]);
});

it("fails if email is not a valid email address", function () {
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => "invalid-email", // Invalid email
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    // Assert that the email is invalid
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["email"]);
});

it("fails if the password_confirmation is missing", function () {
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
    ]);

    // Assert that password_confirmation is required
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["password_confirmation"]);
});

it("returns validation error if email already exists", function () {
    // Create a user in the database
    $user = User::factory()->create();

    // Attempt to register with the same email
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => $user->email, // Existing email
        "password" => fake()->password(),
        "password_confirmation" => fake()->password(),
    ]);

    // Assert validation error for the email
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["email"]);
});

it("fails if password is missing a confirmation", function () {
    $response = $this->post("/api/users/register", [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
        // Missing password_confirmation
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(["password_confirmation"]);
});
