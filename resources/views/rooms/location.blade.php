@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials.room_menu')
            </div>
            <div class="col-md-9">
                <div class="card profile">
                    <div class="card-header">Location</div>
                    <div class="card-body">
                        <div class="container container-small">
                            <form method="POST" action="{{ route('rooms.update', $room) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input
                                        type="text" name="address"
                                        value="{{ old('address') ?? $room->address }}"
                                        placeholder="What is your address?" required
                                        id="address" class="form-control">

                                    @include('partials.error', ['attr' => 'address'])
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-form">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection