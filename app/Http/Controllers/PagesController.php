<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Geocoder\Facades\Geocoder;
use App\Room;

class PagesController extends Controller
{
    protected $room_types = [
        'entire_room' => 'Entire',
        'private_room' => 'Private',
        'shared_room' => 'Shared',
    ];

    protected $count_types = [
        'accommodate' => 'Accommodate',
        'bedroom_count' => 'Bedrooms',
        'bathroom_count' => 'Bathrooms',
    ];

    protected $count_options = [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => '4+',
    ];

    protected $amenities = [
        'has_tv' => 'TV',
        'has_kitchen' => 'Kitchen',
        'has_aircon' => 'Aircon',
        'has_heating' => 'Heating',
        'has_internet' => 'Internet',
    ];

    public function home()
    {
        $rooms = Room::active()->take(3)->get();

        return view('pages.home', compact('rooms'));
    }

    public function search(Request $request)
    {
        if (!empty($queries = $request->query())) {

            // Flash the current request to the session so it will be available for the next request
            $request->flash();

            $rooms = Room::active();

            if ($request->has('address') && !is_null($queries['address'])) {
                $coordinates = Geocoder::getCoordinatesForAddress($request->address);
                $rooms = $rooms->near($coordinates, 5);
            }

            $rooms = $rooms->withPriceBetween($queries['min_price'] ?? null, $queries['max_price'] ?? null)
                        ->withType($this->getChosenRoomTypes($queries['room_type'] ?? null))
                        ->WithAccommodation($queries['accommodate'] ?? null)
                        ->withBedrooms($queries['bedroom_count'] ?? null)
                        ->withBathrooms($queries['bathroom_count'] ?? null)
                        ->withAmenities($queries['amenities'] ?? null)
                        ->get();

            // Filter rooms (remove rooms with reservation on dates chosen)
            if ($request->has('start_date') && $request->has('end_date')) {
                if (!is_null($queries['start_date']) && !is_null($queries['end_date'])) {
                    foreach ($rooms as $key => $room) {
                        $unavailable = $room->reservations()
                                            ->where(function ($query) use ($queries) {
                                                $query->where(function ($query) use ($queries) {
                                                    $query->where('start_date', '>=', $queries['start_date'])
                                                        ->where('start_date', '<=', $queries['end_date']);
                                                })
                                                ->orWhere(function ($query) use ($queries) {
                                                    $query->where('end_date', '>=', $queries['start_date'])
                                                        ->where('end_date', '<=', $queries['end_date']);
                                                })
                                                ->orWhere(function ($query) use ($queries) {
                                                    $query->where('start_date', '<', $queries['start_date'])
                                                        ->where('end_date', '>', $queries['end_date']);
                                                });
                                            })
                                            ->take(1)
                                            ->get();

                        if ($unavailable->count() > 0) {
                            $rooms->forget($key);
                        }
                    }
                }
            }
        }

        return view('pages.search', [
            'room_types' => $this->room_types,
            'count_types' => $this->count_types,
            'count_options' => $this->count_options,
            'amenities' => $this->amenities,
            'rooms' => $rooms ?? [],
        ]);
    }

    private function getChosenRoomTypes($input_room_types)
    {
        if (!is_null($input_room_types)) {
            return collect($this->room_types)->filter(
                function ($room_value, $room_name) use ($input_room_types) {
                    if (isset($input_room_types[$room_name]) && $input_room_types[$room_name] == '1') {
                        return $room_value;
                    }
                }
            )->values()
            ->toArray();
        }
    }
}
