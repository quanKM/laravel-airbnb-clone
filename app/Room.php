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
        return $this->photos->count() > 0 ? Storage::disk('s3')->url($this->photos[0]->path($dimension)) : '/storage/photos/blank.jpg';
    }

    public function nearbys($radius)
    {
        $coordinates = [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
        ];

        return self::near($coordinates, $radius)->where('id', '!=', $this->id)->get();
    }

    public function averageRating()
    {
        return $this->guestReviews()->count() == 0 ? 0 : round($this->guestReviews()->avg('star'));
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeNear($query, $coordinates, $radius)
    {
        // Haversine formula to caculate the great-circle distance between two points on a sphere given their longitudes and latitudes.
        // 6371 => Earth's radius in km and 3959 => Earth's radius in miles
        $form = "( 6371 * acos( cos( radians({$coordinates['lat']}) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians({$coordinates['lng']}) ) + sin( radians({$coordinates['lat']}) ) * sin( radians(latitude) ) ) )";

        $query->when(!is_null($coordinates), function ($q) use ($form, $radius) {
            return $q->select('*')
                     ->selectRaw("{$form} AS distance")
                     ->whereRaw("{$form} < ?", [$radius]);
        });
    }

    public function scopeWithPriceBetween($query, $min_price, $max_price)
    {
        $query->when(!is_null($min_price) && !is_null($max_price), function ($q) use ($min_price, $max_price) {
            return $q->whereBetween('price', [$min_price, $max_price]);
        });
    }

    public function scopeWithType($query, $room_types)
    {
        $query->when(!is_null($room_types), function ($q) use ($room_types) {
            return $q->whereIn('room_type', $room_types);
        });
    }

    public function scopeWithAccommodation($query, $accommodate)
    {
        $query->when(!is_null($accommodate), function ($q) use ($accommodate) {
            return $q->where('accommodate', $accommodate);
        });
    }

    public function scopeWithBedrooms($query, $bedroom_count)
    {
        $query->when(!is_null($bedroom_count), function ($q) use ($bedroom_count) {
            return $q->where('bedroom_count', $bedroom_count);
        });
    }

    public function scopeWithBathrooms($query, $bathroom_count)
    {
        $query->when(!is_null($bathroom_count), function ($q) use ($bathroom_count) {
            return $q->where('bathroom_count', $bathroom_count);
        });
    }

    public function scopeWithAmenities($query, $amenities)
    {
        if (!is_null($amenities)) {
            foreach ($amenities as $key => $value) {
                $query = $query->where($key, $value);
            }

            return $query;
        }
    }
}
