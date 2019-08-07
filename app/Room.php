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
}
