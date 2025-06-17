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
            'headers'  => [
                'Accept'        => 'application/json',
                // اجعل session('api_token') موجودة أو ضع توكن ثابت للاختبار
                'Authorization' => 'Bearer ' . session('api_token', 'YOUR_STATIC_TOKEN'),
            ],
            'timeout'  => 5.0,
        ]);
    }

    public function index(Request $request)
    {
        // تحضير المتغيرات الافتراضية
        $from = now()->subDays(30)->format('d-m-Y');
        $to   = now()->format('d-m-Y');

        // بناء معطيات الطلب
        $formParams = [
            'from_date' => $from,
            'to_date'   => $to,
        ];

        if ($request->filled('search')) {
            $formParams['keywords'] = $request->input('search');
        }
        if ($request->filled('country')) {
            $formParams['country_of_residence'] = $request->input('country');
        }
        if ($request->filled('job_type_id')) {
            $formParams['work_field_id'] = $request->input('job_type_id');
        }

        try {
            $response = $this->client->request('GET', 'ar/api/job-seeker/all-jobs', [
                'form_params' => $formParams,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $jobs = $body['data'] ?? [];

        } catch (\Throwable $e) {
            // سجل الخطأ ومرّر مصفوفة فارغة للعرض
            Log::error("Error fetching jobs: {$e->getMessage()}");
            $jobs = [];
        }

        // قوائم الفلاتر (مثال ثابت؛ يمكنك جلبهم من API إذا أحببت)
        $countries = ['Palestine', 'Jordan', 'Egypt'];
        $jobTypes  = [
            '1' => 'Engineering',
            '2' => 'Design',
            '3' => 'Marketing',
        ];

        return view('jobs.index', compact('jobs', 'countries', 'jobTypes'));
    }

    public function show($id)
    {
        try {
            $response = $this->client->request('GET', "ar/api/job-seeker/job-details/{$id}");
            $body     = json_decode($response->getBody()->getContents(), true);
            $job      = $body['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Error fetching job details ({$id}): ".$e->getMessage());
            $job = [];
        }

        return view('jobs.show', compact('job'));
    }
}
