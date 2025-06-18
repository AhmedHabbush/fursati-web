<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    private Client $client;

    public function __construct()
    {
        // تأكد من أنك تحفظ توكن API في session('api_token')
        $this->middleware(function($request, $next) {
            if (!session('api_token')) {
                // عدّلنا هنا
                return redirect()->route('login');
            }
            return $next($request);
        });

        $this->client = new Client([
            'base_uri' => config('services.api.base_uri'),
            'headers'  => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . Session::get('api_token'),
            ],
            'timeout'  => 5.0,
        ]);
    }

    /**
     * عرض بيانات المستخدم
     */
    public function show()
    {
        try {
            // إذا كان هناك endpoint API للمستخدم، استدعِه هنا
            $response = $this->client->request('GET', 'ar/api/job-seeker/profile');
            $body     = json_decode($response->getBody()->getContents(), true);
            $user     = $body['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Error fetching profile: ".$e->getMessage());
            $user = [];
        }

        return view('profile.show', compact('user'));
    }

    /**
     * تسجيل الخروج (مسح التوكن من الجلسة)
     */
    public function logout(Request $request)
    {
        Session::forget('api_token');
        // يمكنك أيضاً مسح أي بيانات أخرى للجلسة هنا
        return redirect()->route('jobs.index');
    }
}
