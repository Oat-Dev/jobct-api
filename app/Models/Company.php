<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the company.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the applicants.
     */
    public function applicants()
    {
        return $this->hasManyThrough(Applicant::class, Job::class)
            ->where('jobs.company_id', $this->id);
    }

    /**
     * Get the jobs.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the province.
     */
    public function province()
    {
        return $this->belongsTo(AreaProvince::class, 'area_province_id');
    }

    /**
     * Get the district.
     */
    public function district()
    {
        return $this->belongsTo(AreaDistrict::class, 'area_district_id');
    }

    /**
     * Get the sub-district.
     */
    public function sub_district()
    {
        return $this->belongsTo(AreaSubDistrict::class, 'area_sub_district_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'email',
        'tel',
        'profile_photo_path',
        'address',
        'area_province_id',
        'area_district_id',
        'area_sub_district_id',
        'user_id',
    ];
}
