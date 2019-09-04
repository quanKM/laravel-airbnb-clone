<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reservation;
use App\HostReview;
use App\Review;

class HostReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reservation $reservation, Request $request)
    {
        // Check if current host already reviewed the guest in this reservation
        $hasReviewed = HostReview::where('reservation_id', $reservation->id)
                                 ->where('guest_id', $reservation->user_id)
                                 ->where('type', 'HostReview')
                                 ->first();

        if (empty($hasReviewed)) {
            // Have not been reviewed, allow to be reviewed
            Auth::user()->hostReviews()
                        ->create([
                            'star' => $request->star,
                            'comment' => $request->comment,
                            'room_id' => $reservation->room->id,
                            'reservation_id' => $reservation->id,
                            'guest_id' => $reservation->user_id,
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
