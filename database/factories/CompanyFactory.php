<?php

namespace Database\Factories;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->company,
            'logo'          => $this->faker->imageUrl(100,100,'business'),
            'banner'        => $this->faker->imageUrl(400,150,'technics'),
            'business_type' => $this->faker->bs,
            'employees'     => $this->faker->randomElement(['10-50','51-200','201-500','501-1000','1000+']),
            'country'       => $this->faker->country,
            'bio'           => $this->faker->paragraphs(2, true),
            'phone'         => $this->faker->phoneNumber,
        ];
    }
}
