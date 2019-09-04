<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\GuestReview;
use App\Reservation;
use App\Review;

class GuestReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reservation $reservation, Request $request)
    {
        // Check if current guest already reviewed the host in this reservation
        $hasReviewed = GuestReview::where('reservation_id', $reservation->id)
                                 ->where('host_id', $reservation->room->user->id)
                                 ->where('type', 'GuestReview')
                                 ->first();

        if (empty($hasReviewed)) {
            // Have not been reviewed, allow to be reviewed
            Auth::user()->guestReviews()
                        ->create([
                            'star' => $request->star,
                            'comment' => $request->comment,
                            'room_id' => $reservation->room->id,
                            'reservation_id' => $reservation->id,
                            'host_id' => $reservation->room->user->id,
                        ]);

            toastr()->success('Review created successfully!');
        } else {
            // Already reviewed
            toastr()->info('You already reviewed this reservation!');
        }

        return redirect()->back();
    }

    public function destroy(Review $review)
    {
        $review->delete();

        toastr()->success('Review deleted successfully!');

        return redirect()->back();
    }
}
