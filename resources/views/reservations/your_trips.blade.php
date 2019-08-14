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
                    Your Trips
                </div>
                <div class="card-body">
                    @foreach ($trips as $trip)
                        <div class="row">
                            <div class="col-md-2">
                                {{ \Carbon\Carbon::parse($trip->start_date)->toFormattedDateString() }}
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('rooms.show', $trip->room) }}">
                                    <img src="{{ $trip->room->coverPhoto('thumb') }}">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <a href="{{ route('rooms.show', $trip->room) }}">{{ $trip->room->listing_name }}</a>
                                <br><br>
                                <span>
                                    <a href="{{ route('users.show', $trip->room->user) }}">
                                        @if ($trip->room->user->socialAccount)
                                            <img src="{{ $trip->room->user->socialAccount->image }}" class="rounded-circle" width="28px">
                                        @else
                                            <img src="{{ $trip->room->user->gravatar(28) }}" class="rounded-circle">
                                        @endif
                                        {{ $trip->room->user->name }}
                                    </a>
                                </span>
                            </div>
                        </div>
                        <hr/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection