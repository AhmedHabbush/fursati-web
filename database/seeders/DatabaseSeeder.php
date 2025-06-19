<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Job;
use App\Models\Faq;
use App\Models\Policy;
use App\Models\Application;
use App\Models\Favorite;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Company::factory(5)
            ->create()
            ->each(function ($company) {
                Job::factory(rand(3, 8))
                    ->for($company)
                    ->create();
            });

        Faq::factory(10)->create();
        Policy::factory(5)->create();
        User::all()->each(function ($user) {
            $jobIds = Job::inRandomOrder()
                ->take(rand(1, 5))
                ->pluck('id');

            foreach ($jobIds as $jobId) {
                Favorite::create([
                    'user_id' => $user->id,
                    'job_id' => $jobId,
                ]);
            }
        });

        User::all()->each(function ($user) {
            $jobIds = Job::inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id');

            foreach ($jobIds as $jobId) {
                Application::create([
                    'user_id' => $user->id,
                    'job_id' => $jobId,
                    'video_path' => null,
                ]);
            }
        });
    }
}
