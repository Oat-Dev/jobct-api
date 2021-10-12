<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Applicant extends Pivot
{
    use HasFactory;

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'model_id');
    }

    /**
     * Get the user.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    protected $table = 'model_has_jobs';
}
