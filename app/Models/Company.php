<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Company extends Model
{
    protected $fillable = [
        'name','logo','banner','business_type',
        'employees','country','bio','phone',
    ];

    /**
     * الشركة لها عدة وظائف
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
    use HasFactory;
}
