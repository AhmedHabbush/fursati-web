<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    protected $fillable = [
        'company_id','job_type_id','country_id',
        'title','description','salary','experience',
        'job_time','expiration_date','skills',
    ];

    protected $casts = [
        'skills' => 'array',
        'expiration_date' => 'date',
    ];

    /**
     * كل وظيفة تنتمي إلى شركة واحدة
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * المستخدمون الذين حفظوا هذه الوظيفة
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    /**
     * المستخدمون الذين قدموا لهذه الوظيفة
     */
    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'applications')
            ->withPivot('video_path','created_at','updated_at');
    }
    use HasFactory;
}
