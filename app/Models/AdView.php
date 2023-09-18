<?php

namespace App\Models;

use App\Models\User;
use App\Models\Advert;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdView extends Model
{
    use HasFactory;

    protected $table = 'ad_views';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }
}
