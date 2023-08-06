<?php

namespace App\Models;

use App\Models\Location;
use App\Models\SchoolArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';
    protected $guarded = [];
    
    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function school_areas(){
        return $this->hasMany(SchoolArea::class, 'school_id');
    }
}
