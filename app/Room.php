<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function guestReviews()
    {
        return $this->hasMany(GuestReview::class)->where('type', 'GuestReview');
    }

    public function isReady()
    {
    	return (
            $this->price &&
            $this->listing_name &&
            $this->photos()->exists() &&
            $this->address
        );
    }

    public function coverPhoto($dimension)
    {
        return $this->photos->count() > 0 ? Storage::disk('s3')->url($this->photos[0]->path($dimension)) : "/storage/photos/blank.jpg";
    }

    public function nearbys($radius)
    {
        // Haversine formula to caculate the great-circle distance between two points on a sphere given their longitudes and latitudes.
        // 6371 => Earth's radius in km and 3959 => Earth's radius in miles
        $form = "( 6371 * acos( cos( radians($this->latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($this->longitude) ) + sin( radians($this->latitude) ) * sin( radians(latitude) ) ) )";

        return Room::select('*')
                    ->selectRaw("{$form} AS distance")
                    ->whereRaw("{$form} < ?", [$radius])
                    ->where('id', '!=', $this->id)
                    ->get();
    }
}