@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials.room_menu')
            </div>
            <div class="col-md-9">
                <div class="card profile">
                    <div class="card-header">Listing</div>
                    <div class="card-body">
                        <div class="container container-small">
                            <form method="POST" action="{{ route('rooms.update', $room) }}">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="home_type">Home type</label>

                                            @include('partials.form.select', [
                                                'name' => 'home_type',
                                                'options' => $home_types,
                                                'selected' => old('home_type') ?? $room->home_type
                                            ])

                                            @include('partials.error', ['attr' => 'home_type'])
                                        </div>
                                    </div>
        
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="room_type">Room type</label>

                                            @include('partials.form.select', [
                                                'name' => 'room_type',
                                                'options' => $room_types,
                                                'selected' => old('room_type') ?? $room->room_type
                                            ])

                                            @include('partials.error', ['attr' => 'room_type'])
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="accommodate">Accommodate</label>

                                            @include('partials.form.select', [
                                                'name' => 'accommodate',
                                                'options' => $count_options,
                                                'selected' => old('accommodate') ?? $room->accommodate
                                            ])

                                            @include('partials.error', ['attr' => 'accommodate'])
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bedroom_count">Bedrooms</label>

                                            @include('partials.form.select', [
                                                'name' => 'bedroom_count',
                                                'options' => $count_options,
                                                'selected' => old('bedroom_count') ?? $room->bedroom_count
                                            ])

                                            @include('partials.error', ['attr' => 'bedroom_count'])
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bathroom_count">Bathrooms</label>

                                            @include('partials.form.select', [
                                                'name' => 'bathroom_count',
                                                'options' => $count_options,
                                                'selected' => old('bathroom_count') ?? $room->bathroom_count
                                            ])

                                            @include('partials.error', ['attr' => 'bathroom_count'])
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-normal">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection