<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permit>
 */
class PermitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'permit_no' => 'DV0-'
                . fake()->numberBetween(2015, 2030)
                . '-'
                . fake()->unique()->numerify('####'),
            'expires_on' => fake()->dateTimeBetween('-2 years', '+3 years')->format('Y-m-d'),
        ];
    }
}
