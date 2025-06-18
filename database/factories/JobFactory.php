<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Job::class;
    public function definition(): array
    {
        $skills = $this->faker->words(5);
        return [
            // company_id يُحدد لدى الاستخدام via for($company)
            'job_type_id'     => $this->faker->numberBetween(1,5),
            'country_id'      => $this->faker->numberBetween(1,20),
            'title'           => $this->faker->jobTitle,
            'description'     => $this->faker->paragraphs(3, true),
            'salary'          => $this->faker->randomElement(['100$-200$','200$-300$','300$-500$']),
            'experience'      => $this->faker->randomElement(['1 Year','2 Years','3 Years','5+ Years']),
            'job_time'        => $this->faker->date('d-m-Y H:i'),
            'expiration_date' => $this->faker->dateTimeBetween('+1 days','+30 days')->format('Y-m-d'),
            'skills'          => $skills,
        ];
    }
}
