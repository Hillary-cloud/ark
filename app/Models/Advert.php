<?php

namespace App\Models;

use App\Models\User;
use App\Models\Lodge;
use App\Models\AdView;
use App\Models\School;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Bookmark;
use App\Models\Location;
use App\Models\SchoolArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advert extends Model
{
    use HasFactory;

    protected $table = 'adverts';
    
    // protected $fillable = [
    //     'lodge', 'slug', 'location', 'school', 'school_area', 'agent_fee',
    //     'description', 'price', 'negotiable', 'seller_name','phone_number',
    //     'cover_image', 'other_images', 'expiration_date', 'active'
    // ];

    protected $guarded = [];

    protected $casts = [
        'other_images' => 'array',
    ];

    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function school(){
        return $this->belongsTo(School::class, 'school_id');
    }

    public function school_area(){
        return $this->belongsTo(SchoolArea::class, 'school_area_id');
    }

    public function lodge(){
        return $this->belongsTo(Lodge::class, 'lodge_id');
    }

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isBookmarkedByUser($user)
    {
        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function adViews()
    {
        return $this->hasMany(AdView::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
