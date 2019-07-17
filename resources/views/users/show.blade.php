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
                    Email address <br>
                    Phone num
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>{{ $user->name }}</h2>

            <div class="description">
                {{ $user->description }}
            </div>
        </div>
    </div>
</div>
@endsection