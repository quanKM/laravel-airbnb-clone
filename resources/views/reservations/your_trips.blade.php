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
                            <div class="col-md-5">
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
                            <div class="col-md-3">
                                <button type="button" class="btn btn-normal" data-toggle="modal" data-target="#myModal_{{ $trip->id }}">
                                        Review Host
                                </button>

                                    <!-- The Modal -->
                                <div class="modal" id="myModal_{{ $trip->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                                <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title text-left">Review Host</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                                <!-- Modal body -->
                                            <div class="modal-body">
                                                <form action="{{ route('guest-reviews.store', $trip) }}" method="post">
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