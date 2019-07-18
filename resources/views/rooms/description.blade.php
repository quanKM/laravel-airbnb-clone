@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials.room_menu')
            </div>
            <div class="col-md-9">
                <div class="card profile">
                    <div class="card-header">Description</div>
                    <div class="card-body">
                        <div class="container container-small">
                            <form method="POST" action="{{ route('rooms.update', $room) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label for="listing_name">Listing name</label>
                                    <input
                                        type="text" name="listing_name"
                                        value="{{ old('listing_name') ?? $room->listing_name }}"
                                        placeholder="What is your listing name?" required
                                        class="form-control" id="listing_name">

                                        @include('partials.error', ['attr' => 'listing_name'])
                                </div>
                                <div class="form-group">
                                    <label for="summary">Summary</label>
                                    <textarea
                                        type="text" name="summary"
                                        placeholder="Summary of your house" rows="5"
                                        class="form-control" id="summary">{{ old('summary') ?? $room->summary }}</textarea>

                                        @include('partials.error', ['attr' => 'summary'])
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