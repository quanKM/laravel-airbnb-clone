@if ($room->guestReviews->count() == 0)
    <div class="text-center">
        <h4>There are no reviews.</h4>
    </div>
@else
    @foreach ($room->guestReviews as $guestReview)
    <div class="reviews">
        <hr/>
        <div class="row">
            <div class="col-md-3 text-center">
                    @if ($guestReview->guest->socialAccount)
                        <img src="{{ $guestReview->guest->socialAccount->image }}" class="rounded-circle" style="width: 48px; height: 48px;">
                    @else
                        <img src="{{ $guestReview->guest->gravatar(48) }}" class="rounded-circle">
                    @endif
                    <br/><br/>
                <strong>{{ $guestReview->guest->name }}</strong>
            </div>
            <div class="col-md-9">
                <div id="star_{{ $guestReview->id }}"></div>

                @if (Auth::check() && Auth::user()->id == $guestReview->guest->id)
                    <form action="{{ route('guest-reviews.destroy', $guestReview) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-delete float-right" type="submit">
                            <span><i class="fa fa-trash fa-lg"></i></span>
                        </button>
                    </form>
                @endif
                <div>{{ \Carbon\Carbon::parse($guestReview->created_at)->toFormattedDateString() }}</div>
                <div>{{ $guestReview->comment }}</div>
            </div>
        </div>
    </div>
    @endforeach
@endif