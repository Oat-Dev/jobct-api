<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaProvince extends Model
{
    public function geography()
    {
        return $this->belongsTo(AreaGeography::class, 'area_geography_id');
    }

    public function SubDistrict()
    {
        return $this->hasMany(AreaSubDistrict::class)->orderBy('id', 'asc');
    }
}
