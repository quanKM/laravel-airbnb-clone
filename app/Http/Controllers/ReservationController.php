<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Room;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function store(Room $room, Request $request)
    {
        if (Auth::user() == $room->user){
            toastr()->error('You cannot book your own property!');
        } else {
            $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date);
            $days = $end_date->diffInDays($start_date) + 1;

            $reservation = Auth::user()->reservations()->create($request->all());
            $reservation->room()->associate($room);
            $reservation->price = $room->price;
            $reservation->total = $room->price * $days;
            $reservation->save();

            toastr()->success('Booked Successfully!');
        }

        return redirect()->back();
    }

    public function yourTrips()
    {
        $trips = Auth::user()->reservations->sortBy('start_date');

        return view('reservations.your_trips', compact('trips'));
    }
}
