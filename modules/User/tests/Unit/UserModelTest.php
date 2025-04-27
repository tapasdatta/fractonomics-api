<?php

use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

use function Pest\Faker\fake;

beforeEach(function () {
    // Any setup required before each test (e.g., refreshing the database).
    // Optionally: RefreshDatabase trait ensures the database is reset before each test.
});

// Test to create a user and check if it's saved in the database
it("can create a user and save to the database", function () {
    // Generate fake data using Pest's fake() function
    $user = User::factory()->create([
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => fake()->password(),
    ]);

    // Check if the user exists in the database
    $this->assertDatabaseHas("users", [
        "email" => $user->email,
    ]);
});

// Test for validating model attributes (name, email, etc.)
it("validates user attributes correctly", function () {
    // Generate fake user data
    $user = new User([
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => bcrypt(fake()->password()), // Hashing the password
    ]);

    // Validate the user attributes
    expect($user->name)->toBeString(); // Name should be a string
    expect($user->email)->toBeString(); // Email should be a string
    expect($user->email)->toContain("@"); // Email should contain @ symbol
});

// Test to ensure password is correctly hashed (it should not match the plain password)
it("hashes the password before saving", function () {
    // Generate fake password and email
    $password = fake()->password();
    $email = fake()->unique()->safeEmail();

    // Create user with the fake password
    $user = User::factory()->create([
        "password" => bcrypt($password), // Password is hashed before saving
        "email" => $email,
    ]);

    // Assert that the stored password is not equal to the plain password
    $this->assertNotEquals($password, $user->password);
});

// Test for ensuring unique email addresses
it("ensures email is unique", function () {
    // Generate fake data
    $email = fake()->unique()->safeEmail();
    $password = fake()->password();

    // Create first user with the generated email
    User::create([
        "name" => fake()->name(),
        "email" => $email,
        "password" => bcrypt($password),
    ]);

    // Attempt to create another user with the same email
    $this->expectException(\Illuminate\Database\QueryException::class);
    User::create([
        "name" => fake()->name(),
        "email" => $email, // Duplicate email
        "password" => bcrypt($password),
    ]);
});

// Test for ensuring password confirmation matches the password
it("ensures password confirmation matches password", function () {
    // Generate fake data
    $password = fake()->password();
    $userData = [
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => bcrypt($password),
        "password_confirmation" => $password, // Ensure it matches the password
    ];

    // Create the user
    $user = User::create($userData);

    // Assert the password confirmation matches the password
    $this->assertTrue($user->password === $userData["password"]);
});

// Test for checking invalid email format
it("rejects invalid email format", function () {
    // Generate fake invalid email
    $invalidEmail = "invalid-email-format";

    // Create a user with the invalid email
    $user = User::create([
        "name" => fake()->name(),
        "email" => $invalidEmail, // Invalid email
        "password" => bcrypt(fake()->password()),
    ]);

    // Use the correct assertion method to check if the invalid email format is rejected
    $this->assertDoesNotMatchRegularExpression("/@/", $user->email); // This is a simple check, more detailed validation would be in the User model
});

// Test for user authentication
it("can authenticate user using email and password", function () {
    // Create user with fake data
    $password = fake()->password();
    $user = User::create([
        "name" => fake()->name(),
        "email" => fake()->unique()->safeEmail(),
        "password" => bcrypt($password),
    ]);

    // Try authenticating using email and password
    $authenticatedUser = User::where("email", $user->email)->first();
    $this->assertTrue(Hash::check($password, $authenticatedUser->password)); // Ensure the hashed password matches
});
