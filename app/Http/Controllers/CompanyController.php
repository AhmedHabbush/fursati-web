<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
class CompanyController extends Controller
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.api.base_uri'),
            'headers'  => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . session('api_token', 'STATIC_TOKEN'),
            ],
            'timeout' => 5.0,
        ]);
    }

    // عرض صفحة تفاصيل الشركة
    public function show($id)
    {
        // 1) جلب كل الشركات ثم اختيار الشركة المطلوبة
        try {
            $resp = $this->client->request('GET', 'ar/api/all-companies');  // :contentReference[oaicite:0]{index=0}
            $all  = json_decode($resp->getBody()->getContents(), true)['data'] ?? [];
            $company = collect($all)->firstWhere('id', (int)$id) ?? [];
        } catch (\Throwable $e) {
            Log::error("Company fetch error: ".$e->getMessage());
            $company = [];
        }

        // 2) جلب أحدث الوظائف لهذه الشركة
        try {
            $jobsResp = $this->client->request('GET', 'ar/api/job-seeker/all-jobs', [
                'query' => ['business_man_id' => $id]
            ]);  // مع استخدام مفتاح business_man_id :contentReference[oaicite:1]{index=1}
            $jobs = json_decode($jobsResp->getBody()->getContents(), true)['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Company jobs error: ".$e->getMessage());
            $jobs = [];
        }

        return view('companies.show', compact('company','jobs'));
    }

    // عرض صفحة Take Action
    public function action($id)
    {
        // نعيد استخدام بيانات الشركة من show()
        try {
            $resp = $this->client->request('GET', 'ar/api/all-companies');
            $all  = json_decode($resp->getBody()->getContents(), true)['data'] ?? [];
            $company = collect($all)->firstWhere('id', (int)$id) ?? [];
        } catch (\Throwable $e) {
            Log::error("Company fetch error: ".$e->getMessage());
            $company = [];
        }

        return view('companies.action', compact('company'));
    }
}
