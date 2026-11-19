<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        // ----- 1. Your hand-made eatery (D3) -----
        $poblacion = District::where('name', 'Poblacion')->firstOrFail();
        $sukiSerra = Feature::where('name', 'Suki ni Serra')->firstOrFail();
        $budgetMeal = Feature::where('name', 'Budget Meal')->firstOrFail();

        $yourEatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => 'Carinderia ni Serra',
            'slug' => Str::slug('Carinderia ni Serra'),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $yourEatery->permit()->create([
            'permit_no' => 'DVO-2026-1116',
            'expires_on' => '2027-11-16',
        ]);

        $yourEatery->features()->sync([$sukiSerra->id, $budgetMeal->id]);

        $yourEatery->dishes()->createMany([
            ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
            ['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false],
            ['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false],
        ]);

        // ----- 2. Your eatery's reviews (D4) -----
        $tita = User::where('email', 'tita.serra@kaonta.test')->firstOrFail();
        $kaiyou = User::where('email', 'serra@kaonta.test')->firstOrFail();
        $randomUser = User::whereNotIn('id', [$tita->id, $kaiyou->id])->inRandomOrder()->first();

        $yourEatery->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Serra.',
        ]);
        $yourEatery->reviews()->create([
            'user_id' => $kaiyou->id,
            'rating' => fake()->numberBetween(3, 5),
            'body' => fake()->paragraph(),
        ]);
        $yourEatery->reviews()->create([
            'user_id' => $randomUser->id,
            'rating' => fake()->numberBetween(3, 5),
            'body' => fake()->paragraph(),
        ]);

        // ----- 3. Fourteen factory eateries (D1, D4) -----
        $allFeatures = Feature::all();

        $openFactories = Eatery::factory()->count(11)->create();
        $closedFactories = Eatery::factory()->count(3)->closed()->create();
        $allFactories = $openFactories->merge($closedFactories);

        $permitExpired = false;
        foreach ($allFactories as $eatery) {
            if (! $permitExpired) {
                // Guarantee at least one already-expired permit (D4)
                $eatery->permit()->create([
                    'permit_no' => 'DVO-2024-' . fake()->unique()->numerify('####'),
                    'expires_on' => '2024-06-01',
                ]);
                $permitExpired = true;
            } else {
                $eatery->permit()->create(Permit::factory()->raw());
            }

            $dishCount = rand(2, 5);
            $eatery->dishes()->createMany(
                Dish::factory()->count($dishCount)->raw()
            );

            $featureCount = rand(1, 3);
            $featureIds = $allFeatures->random($featureCount)->pluck('id')->toArray();
            $eatery->features()->attach($featureIds);
        }
    }
}
