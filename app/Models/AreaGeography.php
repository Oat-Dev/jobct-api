<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaGeography extends Model
{
    public function provinces()
    {
        return $this->hasMany(AreaProvince::class);
    }
}
