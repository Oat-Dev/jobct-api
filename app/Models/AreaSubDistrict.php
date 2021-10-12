<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaSubDistrict extends Model
{
    public function province()
    {
        return $this->belongsTo(AreaProvince::class);
    }

    public function districts()
    {
        return $this->hasMany(AreaDistrict::class)->orderBy('id', 'asc');
    }
}
