<?php

namespace Modules\Asset\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Asset\Models\Asset;
use Modules\User\Models\User;

class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::factory(), // Assuming the User model is in the App namespace
            "title" => fake()->sentence(3),
            "description" => fake()->paragraph(),
            "currency" => "USD",
            "initial_value" => fake()->randomFloat(2, 1000, 100000), // Random value between 1,000 and 100,000
            "current_value" => fake()->randomFloat(2, 1000, 100000), // Random value between 1,000 and 100,000
            "target_funding" => fake()->randomFloat(2, 5000, 500000), // Random funding target
            "current_funding" => fake()->randomFloat(2, 0, 5000), // Random current funding
            "vote_count" => fake()->numberBetween(0, 1000),
            "funding_deadline" => fake()->dateTimeBetween(
                "+1 week",
                "+1 month"
            ),
            "maturity_date" => fake()->dateTimeBetween("+6 months", "+2 years"),
            "risk_index" => fake()->randomFloat(1, 1, 10), // Risk index between 1.0 and 10.0
            "created_at" => now(),
            "updated_at" => now(),
        ];
    }
}
