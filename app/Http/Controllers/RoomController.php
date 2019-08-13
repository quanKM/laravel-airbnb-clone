<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Geocoder\Facades\Geocoder;
use Carbon\Carbon;
use App\Room;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        // Checks if action is for create or listing, to pass necessary values for select dropdown options
        if (!app()->runningInConsole()) {
            if (Str::contains(request()->route()->getActionName(), ['create', 'listing'])) {
                $home_types = ['Apartment', 'House', 'Bed & Breakfast'];
                $room_types = ['Entire', 'Private', 'Shared'];
                $count_options = [1 => 1, 2 => 2, 3 => 3, 4 => '4+'];

                view()->share(compact(['home_types', 'room_types', 'count_options']));
            }
        }
    }

    public function index()
    {
        $rooms = auth()->user()->rooms;

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $home_types = ['Apartment', 'House', 'Bed & Breakfast'];
        $room_types = ['Entire', 'Private', 'Shared'];
        $count_options = [1 => 1, 2 => 2, 3 => 3, 4 => '4+'];

        return view('rooms.create', compact(['home_types', 'room_types', 'count_options']));
    }

    public function store(Request $request)
    {
        $validator = request()->validate([
            'home_type' => 'required',
            'room_type' => 'required',
            'accommodate' => 'required',
            'bedroom_count' => 'required',
            'bathroom_count' => 'required',
        ]);

        $room = auth()->user()->rooms()->create($validator);

        if ($room) {
            toastr()->success('Saved your room successfully');
        }

        return redirect()->route('rooms.listing', $room);
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'home_type' => 'sometimes|required',
            'room_type' => 'sometimes|required',
            'accommodate' => 'sometimes|required',
            'bedroom_count' => 'sometimes|required',
            'bathroom_count' => 'sometimes|required',
            'price' => 'sometimes|required|numeric|min:1',
        ]);

        $room->fill($request->all());

        if ($request->has('address')) {
            $coordinates =  Geocoder::getCoordinatesForAddress($request->address);

            $room->fill([
                'latitude' => $coordinates['lat'],
                'longitude' => $coordinates['lng']
            ]);
        }

        if ($room->save()) {
            toastr()->success('Saved your room successfully');
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }

    public function publish(Room $room)
    {
        if ($room->isReady()) {
            $room->update(['active' => true]);
        }

        return redirect()->back();
    }

    public function listing(Room $room)
    {
        $home_types = ['Apartment', 'House', 'Bed & Breakfast'];
        $room_types = ['Entire', 'Private', 'Shared'];
        $count_options = [1 => 1, 2 => 2, 3 => 3, 4 => '4+'];

        return view('rooms.listing', compact(['room', 'home_types', 'room_types', 'count_options']));
    }

    public function pricing(Room $room)
    {
        return view('rooms.pricing', compact('room'));
    }

    public function description(Room $room)
    {
        return view('rooms.description', compact('room'));
    }

    public function photos(Room $room)
    {
        return view('rooms.photos', compact('room'));
    }

    public function amenities(Room $room)
    {
        return view('rooms.amenities', compact('room'));
    }

    public function location(Room $room)
    {
        return view('rooms.location', compact('room'));
    }

    public function preload(Room $room)
    {
        $today = Carbon::now()->format('Y-m-d');
        $reservations = $room->reservations()->where('start_date', '>=', $today)
                                             ->orWhere('end_date', '>=', $today)
                                             ->get();

        return response()->json($reservations);
    }
}
