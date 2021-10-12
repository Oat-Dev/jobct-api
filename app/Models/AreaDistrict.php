<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaDistrict extends Model
{
    public function SubDistrict()
    {
        return $this->belongsTo(AreaSubDistrict::class);
    }
}
