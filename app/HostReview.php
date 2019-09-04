<?php

namespace App;

use App\Review;

class HostReview extends Review
{
    protected $table = 'reviews';

    protected $attributes = [
        'type' => 'HostReview',
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }
}
