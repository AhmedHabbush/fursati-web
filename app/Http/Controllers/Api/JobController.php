<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    /**
     * GET /api/ar/api/job-seeker/all-jobs
     */
    public function index(Request $request)
    {
        // 1) بناء query مع الفلاتر
        $q = Job::with('company');

        if ($request->filled('title')) {
            $q->where('title', 'like', "%{$request->title}%");
        }
        if ($request->filled('country_id')) {
            $q->where('country_id', $request->country_id);
        }
        if ($request->filled('job_type_id')) {
            $q->where('job_type_id', $request->job_type_id);
        }

        // 2) جلب النتائج مع pagination
        $jobs = $q->paginate(10);

        return response()->json(['data' => $jobs]);
    }

    /**
     * GET /api/ar/api/job-seeker/job-details/{id}
     */
    public function show($id)
    {
        // جلب الوظيفة مع الشركة، والمستخدمين الذين حفظوها، والمتقدّمين
        $job = Job::with('company', 'favoritedBy', 'applicants')->find($id);

        if (!$job) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json(['data' => $job]);
    }

    /**
     * POST /api/ar/api/job-seeker/jobs/{id}/mark-favorite
     */
    public function toggleFavorite($id)
    {
        $user = Auth::user(); // تأكد أنك تستخدم توكن API مع Sanctum أو Passport
        $job = Job::findOrFail($id);

        if ($user->favoriteJobs()->where('job_id', $id)->exists()) {
            $user->favoriteJobs()->detach($id);
            $message = 'Removed from favorites';
        } else {
            $user->favoriteJobs()->attach($id);
            $message = 'Added to favorites';
        }

        return response()->json(['message' => $message]);
    }

    /**
     * GET /api/ar/api/job-seeker/favorite-jobs
     */
    public function favoriteJobs()
    {
        $user = Auth::user();
        $jobs = $user->favoriteJobs()->with('company')->get();
        return response()->json(['data' => $jobs]);
    }

    /**
     * POST /api/ar/api/job-seeker/jobs/applied/{id}
     */
    public function apply(Request $request, $id)
    {
        $user = Auth::user();
        $job = Job::findOrFail($id);

        // 1) حمّل الفيديو لو وُجد
        $path = null;
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('applications', 'public');
        }

        // 2) سجّل التقديم
        $user->appliedJobs()->syncWithoutDetaching([
            $id => ['video_path' => $path]
        ]);

        return response()->json(['message' => 'Applied successfully']);
    }
}
