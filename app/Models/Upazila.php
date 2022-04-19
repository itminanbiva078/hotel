<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upazila extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    public function district()
    {
        return $this->belongsTo(District::class,'district_id', 'id');
    }

}
