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
                                <div class="col-md-8">
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