<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


class SettingsController extends Controller
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
            'timeout' => 5.0,
        ]);
    }

    // 1. جلب وعرض كل الـ FAQs
    public function faqs()
    {
        try {
            $resp = $this->client->request('GET', 'ar/api/faqs');
            $faqs = json_decode($resp->getBody()->getContents(), true)['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Error fetching FAQs: ".$e->getMessage());
            $faqs = [];
        }
        return view('settings.faqs', compact('faqs'));
    }

    // 2. عرض تفاصيل سؤال واحد
    public function faqDetail($id)
    {
        try {
            $resp = $this->client->request('GET', "ar/api/faqs/{$id}");
            $faq  = json_decode($resp->getBody()->getContents(), true)['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Error fetching FAQ {$id}: ".$e->getMessage());
            $faq = [];
        }
        return view('settings.faq-detail', compact('faq'));
    }

    // 3. جلب وعرض السياسات
    public function policies()
    {
        try {
            $resp     = $this->client->request('GET', 'ar/api/policies');
            $policies = json_decode($resp->getBody()->getContents(), true)['data'] ?? [];
        } catch (\Throwable $e) {
            Log::error("Error fetching policies: ".$e->getMessage());
            $policies = [];
        }
        return view('settings.policies', compact('policies'));
    }
    /**
     * عرض نموذج Help & Feedback
     */
    public function help()
    {
        return view('settings.help');
    }

    /**
     * معالجة إرسال Help & Feedback
     */
    public function submitHelp(Request $request)
    {
        // 1. تحقق من المدخلات
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|max:150',
            'subject'     => 'required|string|max:150',
            'message'     => 'required|string',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|max:5120', // 5MB لكل ملف
        ]);

        // 2. احفظ المرفقات إن وُجدت
        $savedFiles = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $savedFiles[] = $file->store('help-feedback', 'public');
            }
        }

        // 3. (اختياري) يمكنك هنا إرسال رسالة بريد أو تخزين البيانات في DB
        // مثلاً: Mail::to(config('mail.support'))->send(new HelpFeedbackMail($data, $savedFiles));

        // 4. رجع للمستخدم برسالة نجاح
        return back()->with('success', 'شكرًا لرسالتك! سنعاود الاتصال بك قريبًا.');
    }
}
