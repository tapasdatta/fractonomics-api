<?php

use Modules\User\Models\User;
use function Pest\Faker\fake;

beforeEach(function () {
    // Optionally reset the database or perform setup tasks
});

it("successfully logs in with valid credentials", function () {
    // Use login helper to create and authenticate a user
    $user = login(); // The helper will create and log in the user

    // Send login request with valid credentials
    $response = $this->post("/api/users/sanctum/token", [
        "email" => $user->email,
        "password" => "password", // The password should match the default in the helper or create logic
    ]);

    // Assert that the response contains a token and is a success
    $response->assertStatus(200);
    $response->assertJson([
        "status" => "success",
        "message" => "Login token generated successfully",
    ]);
    $this->assertArrayHasKey("token", $response->json());
});

it("fails when the email is incorrect", function () {
    // Use login helper to create and authenticate a user
    $user = login(); // The helper will create and log in the user

    // Attempt login with a non-existent email
    $response = $this->post("/api/users/sanctum/token", [
        "email" => fake()->unique()->safeEmail(), // Invalid email
        "password" => "password", // Correct password (this doesn't matter since email is invalid)
    ]);

    // Assert that the response has an error message for the email
    $response->assertStatus(401); // Unauthorized
    $response->assertJson([
        "message" => "The provided credentials are incorrect.",
        "errors" => [
            "email" => ["The provided credentials are incorrect."],
        ],
    ]);
});

it("fails when the password is incorrect", function () {
    // Use login helper to create and authenticate a user
    $user = login(); // The helper will create and log in the user

    // Attempt login with correct email but incorrect password
    $response = $this->post("/api/users/sanctum/token", [
        "email" => $user->email,
        "password" => "incorrect-password", // Wrong password
    ]);

    // Assert that the response has an error message for the password
    $response->assertStatus(401); // Unauthorized
    $response->assertJson([
        "message" => "The provided credentials are incorrect.",
        "errors" => [
            "email" => ["The provided credentials are incorrect."],
        ],
    ]);
});

it("fails when email is not provided", function () {
    // Attempt login with no email
    $response = $this->post("/api/users/sanctum/token", [
        "password" => fake()->password(),
    ]);

    // Assert that the email is required
    $response->assertStatus(422); // Unprocessable Entity
    $response->assertJsonValidationErrors(["email"]);
});

it("fails when password is not provided", function () {
    // Attempt login with no password
    $response = $this->post("/api/users/sanctum/token", [
        "email" => fake()->unique()->safeEmail(),
    ]);

    // Assert that the password is required
    $response->assertStatus(422); // Unprocessable Entity
    $response->assertJsonValidationErrors(["password"]);
});

it("fails when both email and password are incorrect", function () {
    // Attempt login with wrong credentials
    $response = $this->post("/api/users/sanctum/token", [
        "email" => fake()->unique()->safeEmail(), // Invalid email
        "password" => "incorrect-password", // Invalid password
    ]);

    // Assert that the response returns an error
    $response->assertStatus(401); // Unauthorized
    $response->assertJson([
        "message" => "The provided credentials are incorrect.",
        "errors" => [
            "email" => ["The provided credentials are incorrect."],
        ],
    ]);
});

it("fails if the user is deactivated", function () {
    // Create a deactivated user
    $user = User::factory()->create([
        "password" => bcrypt($password = fake()->password()), // Store a password
        "is_active" => false, // Deactivated user
    ]);

    // Attempt to log in with the deactivated user
    $response = $this->post("/api/users/sanctum/token", [
        "email" => $user->email,
        "password" => $password,
    ]);

    // Assert that the response returns an error (can be customized)
    $response->assertStatus(401); // Unauthorized
    $response->assertJson([
        "message" => "The provided credentials are incorrect.",
        "errors" => [
            "email" => ["The provided credentials are incorrect."],
        ],
    ]);
});
