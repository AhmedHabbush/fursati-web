<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }
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
        // جلب الأسئلة كـ array كي تعمل مع $faq['question']
        $faqs = Faq::select('id','question','answer')->get()->toArray();

        return view('settings.faqs', compact('faqs'));
    }

    // صفحة تفاصيل سؤال واحد
    public function faqDetail($id)
    {
        $faq = Faq::findOrFail($id);
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

        // 3. يمكنك هنا إرسال رسالة بريد أو تخزين البيانات في DB
        // مثلاً: Mail::to(config('mail.support'))->send(new HelpFeedbackMail($data, $savedFiles));

        // 4. رجع للمستخدم برسالة نجاح
        return back()->with('success', 'شكرًا لرسالتك! سنعاود الاتصال بك قريبًا.');
    }
    public function language()
    {
        // خذ اللغة الحالية من الجلسة أو من إعدادات التطبيق
        $current = session('locale', app()->getLocale());

        // خيارات اللغة
        $options = [
            'ar' => 'العربية',
            'en' => 'English',
        ];

        return view('settings.language', compact('current', 'options'));
    }

    // حفظ اللغة المختارة
    public function setLanguage(Request $request)
    {
        $data = $request->validate([
            'language' => 'required|in:ar,en',
        ]);

        // خزّن الاختيار في الجلسة
        session(['locale' => $data['language']]);

        return redirect()
            ->route('settings.language')
            ->with('success', 'تم تغيير اللغة إلى ' . ($data['language'] === 'ar' ? 'العربية' : 'English'));
    }

    // 3. عرض صفحة التنبيهات
    public function notifications()
    {
        $pref = Auth::user()->preference
            ?? new UserPreference();
        return view('settings.notifications', [
            'jobAlerts'     => $pref->notify_job_alerts,
            'messageAlerts' => $pref->notify_message_alerts,
        ]);
    }

    // 4. حفظ إعدادات التنبيهات
    public function setNotifications(Request $request)
    {
        $data = $request->validate([
            'notify_job_alerts'     => 'boolean',
            'notify_message_alerts' => 'boolean',
        ]);

        $user = Auth::user();
        $pref = $user->preference
            ? tap($user->preference)->update($data)
            : $user->preference()->create($data);

        return redirect()->route('settings.notifications')
            ->with('success', 'تم تحديث إعدادات التنبيهات');
    }
}
