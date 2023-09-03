<?php

namespace App\Models;

use app\Models\Advert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $guarded = [];

    public function adverts()
{
    return $this->hasMany(Advert::class);
}
    

}
