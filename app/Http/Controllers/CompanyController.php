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
        $company = \App\Models\Company::with('jobs')->findOrFail($id);
        return view('companies.show', compact('company'));
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
