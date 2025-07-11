<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1,10),
            'job_id'  => $this->faker->numberBetween(1,50),
        ];
    }
}
