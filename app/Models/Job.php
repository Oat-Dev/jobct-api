<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Job extends Model
{
    use HasFactory;
    use HasTrixRichText;

    /**
     * Get the company that owns the job.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Get the applicant jobs.
     */
    public function jobs()
    {
        return $this->morphByMany(Job::class, 'job', 'model_has_jobs');
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) return $query;

        return $query->where('name', 'ilike', '%' . $search . '%');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'job-trixFields',
        'attachment-job-trixFields',
        'description',
        'amount',
        'salary',
        'optional_work_from_home',
        'company_id',
    ];
}
