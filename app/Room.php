<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
