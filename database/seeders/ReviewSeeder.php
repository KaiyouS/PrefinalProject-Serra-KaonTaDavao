<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $openFactoryEateries = Eatery::where('is_open', true)
            ->where('name', '!=', 'Carinderia ni Serra')
            ->get();

        $userIds = User::pluck('id')->toArray();

        foreach ($openFactoryEateries as $eatery) {
            $reviewCount = rand(0, 6);

            for ($i = 0; $i < $reviewCount; $i++) {
                $eatery->reviews()->create([
                    'user_id' => fake()->randomElement($userIds),
                    'rating' => rand(1, 5),
                    'body' => fake()->paragraph(),
                ]);
            }
        }
    }
}
