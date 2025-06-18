<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Job;
class JobController extends Controller
{
    public function index(Request $request)
    {
        // 1) بناء query مع eager‐loading لمعلومات الشركة
        $q = Job::with('company');

        // 2) تطبيق الفلاتر
        if ($request->filled('search')) {
            $q->where('title', 'like', "%{$request->search}%");
        }
        if ($request->filled('country_id')) {
            $q->where('country_id', $request->country_id);
        }
        if ($request->filled('job_type_id')) {
            $q->where('job_type_id', $request->job_type_id);
        }

        // 3) جلب النتائج مع pagination
        $jobs = $q->paginate(10);

        // 4) قائمة البلدان وأنواع الوظائف (يمكن جلبها من DB أو تركها ثابتة)
        $countries = [
            ['id'=>1,'name'=>'Palestine'],
            ['id'=>2,'name'=>'Jordan'],
            ['id'=>3,'name'=>'Egypt'],
        ];
        $jobTypes = [
            ['id'=>1,'title'=>'Engineering'],
            ['id'=>2,'title'=>'Design'],
            ['id'=>3,'title'=>'Marketing'],
        ];

        // 5) تمرير البيانات إلى الـ view
        return view('jobs.index', compact('jobs','countries','jobTypes'));
    }
    public function show($id)
    {
        // جلب الوظيفة مع الشركة والمفضّلين والمتقدّمين (إذا أردت)
        $job = Job::with('company','favoritedBy','applicants')->findOrFail($id);

        return view('jobs.show', compact('job'));
    }
    /**
     * إرسال طلب التقديم على الوظيفة
     */
    public function apply(Request $request, $id)
    {
        // نتحقّق من وجود التوكن (أي تسجيل دخول)
        if (! session('api_token')) {
            // من يعيدنا للصفحة نفسها مع رسالة خطأ
            return back()->with('error', 'You must be logged in to apply.');
        }

        // ملف الفيديو إن وُجد
        $fileParams = [];
        if ($request->hasFile('video')) {
            $fileParams['video'] = fopen($request->file('video')->getPathname(), 'r');
        }

        try {
            $response = $this->client->request('POST', "ar/api/job-seeker/jobs/applied/{$id}", [
                'multipart' => array_merge(
                    [['name' => 'job_id', 'contents' => $id]],
                    $fileParams
                ),
            ]);
            Session::flash('success', 'تم التقديم بنجاح!');
        } catch (\Throwable $e) {
            Log::error("Error applying job {$id}: ".$e->getMessage());
            Session::flash('error', 'حدث خطأ أثناء التقديم، حاول مجددًا.');
        }

        return back();
    }
}
