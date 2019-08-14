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
                    Listings
                </div>
                <div class="card-body">
                    @foreach ($rooms as $room)
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{ $room->coverPhoto('thumb') }}" alt="">
                            </div>
                            <div class="col-md-7">
                                <h4>{{ $room->listing_name }}</h4>
                            </div>
                            <div class="col-md-3">
                                <form action=""></form>
                                <a href="{{ route('rooms.listing', $room) }}" class="btn btn-form">Update</a>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection