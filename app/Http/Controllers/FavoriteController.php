<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;

class FavoriteController extends Controller
{
    // عرض صفحة المحفوظات
    public function index()
    {
        $user = Auth::user();
        $favorites = $user
            ->favoriteJobs()
            ->with('company')
            ->paginate(10);

        return view('bookmarks.index', compact('favorites'));
    }

    // تبديل حالة الحفظ/الإلغاء
    public function toggle($jobId)
    {
        $user = Auth::user();
        $job = Job::findOrFail($jobId);

        if ($user->favoriteJobs()->where('job_id', $jobId)->exists()) {
            $user->favoriteJobs()->detach($jobId);
        } else {
            $user->favoriteJobs()->attach($jobId);
        }

        return back();
    }
}
