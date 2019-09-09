<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class PagesController extends Controller
{
    public function home()
    {
        $rooms = Room::active()->take(3)->get();

        return view('pages.home', compact('rooms'));
    }

    public function search()
    {
        $room_types = [
            'entire_room' => 'Entire',
            'private_room' => 'Private',
            'shared_room' => 'Shared'
        ];

        $count_types = [
            'accommodate' => 'Accommodate',
            'bedroom_count' => 'Bedrooms',
            'bathroom_count' => 'Bathrooms'
        ];

        $count_options = [1 => 1, 2 => 2, 3 => 3, 4 => '4+'];

        $amenities = [
            'has_tv' => 'TV',
            'has_kitchen' => 'Kitchen',
            'has_aircon' => 'Aircon',
            'has_heating' => 'Heating',
            'has_internet' => 'Internet',
        ];

        return view('pages.search', compact('room_types', 'count_types', 'count_options', 'amenities'));
    }
}
