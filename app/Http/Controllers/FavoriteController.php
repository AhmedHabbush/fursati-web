<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.api.base_uri'),
            'headers'  => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . session('api_token', 'YOUR_STATIC_TOKEN'),
            ],
            'timeout'  => 5.0,
        ]);
    }

    // عرض الوظائف المحفوظة
    public function index()
    {
        try {
            $response = $this->client->request('GET', 'ar/api/job-seeker/favorite-jobs');
            $body     = json_decode($response->getBody()->getContents(), true);
            $jobs     = $body['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Error fetching favorite jobs: " . $e->getMessage());
            $jobs = [];
        }

        return view('bookmarks.index', compact('jobs'));
    }

    // تبديل الحفظ/إلغاء الحفظ
    public function toggle($id)
    {
        try {
            $this->client->request('POST', "ar/api/job-seeker/jobs/{$id}/mark-favorite");
        } catch (\Throwable $e) {
            Log::error("Error toggling favorite for job {$id}: " . $e->getMessage());
        }

        return back();
    }
}
