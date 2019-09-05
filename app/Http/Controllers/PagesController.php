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
}
