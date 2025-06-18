<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    protected $jobs = [
        [
            'id'=>1,
            'title'=>'Web and Mobile Development',
            'job_time'=>'30 min',
            'company'=>[
                'id'=>1012416,
                'name'=>'PURE for IT Solutions',
                'logo'=>'https://via.placeholder.com/24',
                'views'=>21
            ],
            'job_type'=>['title'=>'Engineering'],
            'salary'=>'100$ - 250$',
            'experience'=>'3 Years',
            'remaining_days'=>'3 days rem.',
            'description'=>'Lorem ipsum dolor sit amet…',
            'skills'=>['Java','JavaScript','Bootstrap'],
            'is_favorite'=>false,
            'business_man_id'=>1,
        ],
        // أضف المزيد حسب الحاجة…
    ];

    // GET /ar/api/job-seeker/all-jobs
    public function index(Request $req)
    {
        // هنا يمكنك تطبيق الفلاتر من $req->all()
        return response()->json(['data'=>$this->jobs]);
    }

    // GET /ar/api/job-seeker/job-details/{id}
    public function show($id)
    {
        $job = collect($this->jobs)->firstWhere('id',(int)$id);
        if (! $job) {
            return response()->json(['message'=>'Not Found'],404);
        }
        return response()->json(['data'=>$job]);
    }

    // POST /ar/api/job-seeker/jobs/{id}/mark-favorite
    public function toggleFavorite($id)
    {
        // في الواقع: يجب تحديث في الـ DB. هنا نُعيد حالة مُقلوبة.
        return response()->json(['message'=>'Toggled favorite for job '.$id]);
    }

    // GET /ar/api/job-seeker/favorite-jobs
    public function favoriteJobs()
    {
        // في الواقع: جلب من DB؛ هنا نعيد الثابتة.
        $favorites = array_filter($this->jobs, fn($j)=> $j['is_favorite']);
        return response()->json(['data'=>array_values($favorites)]);
    }

    // POST /ar/api/job-seeker/jobs/applied/{id}
    public function apply(Request $req, $id)
    {
        // هنا تعالج رفع الفيديو إن وُجد: $req->file('vedio')
        return response()->json(['message'=>'Applied to job '.$id]);
    }
}
