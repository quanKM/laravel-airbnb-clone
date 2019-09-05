@foreach ($rooms as $room)
    <div class="col-md-4">
        <div class="card h-100 profile">
            <div class="card-header h-100 p-0">
                <img class="w-100 h-100" src="{{ $room->coverPhoto('medium') }}" alt="">
            </div>
            <div class="card-body">
                <a href="{{ route('rooms.show', $room) }}">{{ $room->listing_name }}</a><br>
                {{ $room->price }} - {{ $room->home_type }} - {{ $room->bedroom_count }} {{ str_plural("bed", $room->bedroom_count) }}
                <div id="star_{{ $room->id }}"></div>{{ $room->guestReviews->count() }} {{ str_plural("review", $room->guestReviews->count()) }}
            </div>
        </div>
    </div>
@endforeach

@section('scripts')
    @parent

    @foreach ($rooms as $room)
        <script>
            $('#star_{{ $room->id }}').raty({
                path: '/images',
                readOnly: true,
                score: {{ $room->averageRating() }}
            });
        </script>
    @endforeach
@endsection

