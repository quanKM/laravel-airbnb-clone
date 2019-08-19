@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @if ($user->socialAccount)
                <img src="{{ $user->socialAccount->image . '&width=300&height=300' }}" alt="" class="w-100">
            @else
                <img src="{{ $user->gravatar(200) }}" class="w-100">
            @endif

            <div class="card profile mt-4">
                <div class="card-header">Verification</div>
                <div class="card-body">
                    <ul class="sidebar list-unstyled">
                        @if ($user->socialAccount)
                            <li class="p-0">Facebook<span class="float-right"><i class="far fa-check-circle text-secondary"></i></span></li>
                        @else
                            <li class="p-0">Email Address<span class="float-right"><i class="far fa-check-circle text-secondary"></i></span></li>
                        @endif
                        <li class="p-0">Phone Number<span class="float-right"><i class="far fa-check-circle text-secondary"></i></span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>{{ $user->name }}</h2>

            <div class="description my-4">
                {{ $user->description }}
            </div>

            <h4>Listings ({{ $user->rooms->count() }})</h4>
            <br/>

            <div class="row">
                @foreach ($user->rooms as $room)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header p-0">
                                <img class="w-100" src="{{ $room->coverPhoto('medium') }}" alt="">
                            </div>
                            <div class="card-body">
                                <a href="{{ route('rooms.show', $room) }}">{{ $room->listing_name }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection