@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('partials.sidebar', ['route' => Route::currentRouteName()])
        </div>
        <div class="col-md-9">
            <div class="card profile">
                <div class="card-header">
                    Your Reservations
                </div>
                <div class="card-body">
                    @foreach ($rooms as $room)
                        @foreach ($room->reservations as $reservation)
                            <div class="row">
                                <div class="col-md-2">
                                    {{ \Carbon\Carbon::parse($reservation->start_date)->toFormattedDateString() }}
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('rooms.show', $reservation->room) }}">
                                        <img src="{{ $reservation->room->coverPhoto('thumb') }}" alt="">
                                    </a>
                                </div>
                                <div class="col-md-5">
                                    <a href="{{ route('rooms.show', $reservation->room) }}">{{ $room->listing_name }}</a>
                                    <br><br>
                                    <span>
                                        <a href="{{ route('users.show', $reservation->user) }}">
                                            @if ($reservation->user->socialAccount)
                                                <img src="{{ $reservation->user->socialAccount->image }}" class="rounded-circle" width="28px">
                                            @else
                                                <img src="{{ $reservation->user->gravatar(28) }}" class="rounded-circle">
                                            @endif
                                            {{ $reservation->user->name }}
                                        </a>
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <!-- Button to Open the Modal -->
                                    <button type="button" class="btn btn-normal" data-toggle="modal" data-target="#myModal_{{ $reservation->id }}">
                                        Review Guest
                                    </button>

                                    <!-- The Modal -->
                                    <div class="modal" id="myModal_{{ $reservation->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title text-left">Review Guest</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form action="{{ route('host-reviews.store', $reservation) }}" method="post">
                                                        @csrf
                                                        <div class="form-group text-center">
                                                            <div class="star"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                                                        </div>

                                                        <div class="text-center">
                                                            <button class="btn btn-normal" type="submit">Add Review</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.star').raty({
        path: '/images',
        scoreName: 'star',
        score: 1
    });
</script>
@endsection