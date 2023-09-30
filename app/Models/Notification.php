<?php

namespace App\Models;
use App\Models\Advert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }
}
