<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\School;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $guarded = [];

    public function schools(){
        return $this->hasMany(School::class, 'location_id');
    }

    
}
