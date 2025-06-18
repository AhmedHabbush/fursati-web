<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Application::class;

    public function definition()
    {
        return [
            'user_id'    => $this->faker->numberBetween(1,10),
            'job_id'     => $this->faker->numberBetween(1,50),
            'video_path' => null,
        ];
    }
}
