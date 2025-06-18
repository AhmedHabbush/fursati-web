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
        // 1) مستخدمون تجريبيون
        User::factory(10)->create();

        // 2) شركات ووظائفها
        Company::factory(5)
            ->create()
            ->each(function ($company) {
                // لكل شركة 3-8 وظائف
                Job::factory(rand(3, 8))
                    ->for($company)
                    ->create();
            });

        // 3) FAQs و Policies
        Faq::factory(10)->create();
        Policy::factory(5)->create();
        // 4) seeding Favorites بشكل آمن
        User::all()->each(function ($user) {
            // نأخذ عدد عشوائي من الوظائف (مثلاً 1 إلى 5)
            $jobIds = Job::inRandomOrder()
                ->take(rand(1, 5))
                ->pluck('id');

            // ننشئ العلاقة لكل job_id موجود
            foreach ($jobIds as $jobId) {
                Favorite::create([
                    'user_id' => $user->id,
                    'job_id' => $jobId,
                ]);
            }
        });

        // 5) seeding Applications بشكل آمن
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
//        // 4) عينات لحفظ الوظائف والتقديم
//        \App\Models\Favorite::factory(20)->create();
//        \App\Models\Application::factory(15)->create();
}
