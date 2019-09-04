@if ($hostReviews->count() == 0)
    <div class="text-center">
        <h4>There are no reviews.</h4>
    </div>
@else
    @foreach ($hostReviews as $hostReview)
    <div class="reviews">
        <hr/>
        <div class="row">
            <div class="col-md-3 text-center">
                @if ($hostReview->host->socialAccount)
                    <img src="{{ $hostReview->host->socialAccount->image }}" class="rounded-circle" style="width: 48px; height: 48px;">
                @else
                    <img src="{{ $hostReview->host->gravatar(48) }}" class="rounded-circle">
                @endif
                <br><br>
                <strong>{{ $hostReview->host->name }}</strong>
            </div>
            <div class="col-md-9">
                <div id="star_{{ $hostReview->id }}"></div>
                
                @if (Auth::check() && Auth::user()->id == $hostReview->host->id)
                    <form action="{{ route('host-reviews.destroy', $hostReview) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-delete float-right" type="submit">
                            <span><i class="fa fa-trash fa-lg"></i></span>
                        </button>
                    </form>
                @endif
                <div>{{ \Carbon\Carbon::parse($hostReview->created_at)->toFormattedDateString() }}</div>
                <div>{{ $hostReview->comment }}</div>
            </div>
        </div>
    </div>
    @endforeach
@endif

@section('scripts')
    @foreach ($hostReviews as $hostReview)
        <script>
            $('#star_{{ $hostReview->id }}').raty({
                path: '/images',
                readOnly: true,
                score: {{ $hostReview->star }}
            });
        </script>
    @endforeach
@endsection