<?php

namespace App;

use App\Review;

class GuestReview extends Review
{
    protected $table = 'reviews';

    protected $attributes = [
        'type' => 'GuestReview',
    ];
    
    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }
}
