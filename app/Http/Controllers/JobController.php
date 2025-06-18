<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            // تأكد أن API_BASE_URL في .env ينتهي بشرطة مائلة /
            'base_uri' => config('services.api.base_uri'),
            'headers' => [
                'Accept' => 'application/json',
                // اجعل session('api_token') موجودة أو ضع توكن ثابت للاختبار
                'Authorization' => 'Bearer ' . session('api_token', 'YOUR_STATIC_TOKEN'),
            ],
            'timeout' => 5.0,
        ]);
    }

    public function index(Request $request)
    {
        // 1. إعداد التواريخ الافتراضية
        $from = now()->subDays(30)->format('d-m-Y');
        $to   = now()->format('d-m-Y');

        // 2. بناء معطيات الفلترة
        $params = [
            'from_date' => $from,
            'to_date'   => $to,
        ];

        // بحث بالكلمة المفتاحية → key = title
        if ($request->filled('search')) {
            $params['title'] = $request->input('search');
        }

        // فلتر بالدولة → key = country_of_residence
        if ($request->filled('country_of_residence')) {
            $params['country_of_residence'] = $request->input('country_of_residence');
        }

        // فلتر مجال العمل → key = work_field_id
        if ($request->filled('work_field_id')) {
            $params['work_field_id'] = $request->input('work_field_id');
        }

        // 3. استدعاء API الوظائف مع إرسال الفلترات كـ Query String
        try {
            $response = $this->client->request('GET', 'ar/api/job-seeker/all-jobs', [
                'query' => $params,
            ]);  // keys: from_date, to_date, country_of_residence, work_field_id, title :contentReference[oaicite:0]{index=0}

            $body = json_decode($response->getBody()->getContents(), true);
            $jobs = $body['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Error fetching jobs: " . $e->getMessage());
            $jobs = [];
        }

        // 4. تجهيز قوائم الفلاتر (يمكن جلبهم من API /all-companies أو ملف محلي)
        $countries = [
            ['id' => 1, 'name' => 'Palestine'],
            ['id' => 2, 'name' => 'Jordan'],
            ['id' => 3, 'name' => 'Egypt'],
        ];

        $jobTypes = [
            ['id' => 1, 'title' => 'Engineering'],
            ['id' => 2, 'title' => 'Design'],
            ['id' => 3, 'title' => 'Marketing'],
        ];

        // 5. إرجاع الـ View مع البيانات
        return view('jobs.index', [
            'jobs'      => $jobs,
            'countries' => $countries,
            'jobTypes'  => $jobTypes,
        ]);
    }

    public function show($id)
    {
        try {
            $response = $this->client->request('GET', "ar/api/job-seeker/job-details/{$id}");
            $body = json_decode($response->getBody()->getContents(), true);
            $job = $body['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Error fetching job details ({$id}): " . $e->getMessage());
            $job = [];
        }

        return view('jobs.show', compact('job'));
    }
}
