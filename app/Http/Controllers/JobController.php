<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class JobController extends Controller
{
    protected Client $client;

    public function __construct()
    {
        // تأكد من تعريف APP_URL_API في .env مثلاً
        $this->client = new Client([
            'base_uri' => config('app.url')  // أو config('services.api.base_uri')
        ]);
    }

    public function index(Request $request)
    {
        // مثال على تاريخ البداية والنهاية (يمكنك تعديل الفلاتر لاحقاً)
        $from = now()->subDays(30)->format('d-m-Y');
        $to   = now()->format('d-m-Y');

        $response = $this->client->request('GET', '/ar/api/job-seeker/all-jobs', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer '.session('api_token')  // أو ثابت للاختبار
            ],
            'form_params' => [
                'from_date'             => $from,
                'to_date'               => $to,
                // يمكنك هنا تمرير فلاتر إضافية: country_of_residence, work_field_id… إلخ
            ],
        ]);  // :contentReference[oaicite:0]{index=0}

        $body = json_decode($response->getBody(), true);
        // تفترض أنّ الـ data تحتوي على مصفوفة الوظائف
        $jobs = $body['data'] ?? [];

        return view('jobs.index', compact('jobs'));
    }
}
