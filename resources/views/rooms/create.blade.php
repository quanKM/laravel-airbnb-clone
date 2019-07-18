@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card profile">
            <div class="card-header">
                Create your byutifoo places
            </div>
            <div class="card-body">
                <div class="container container-small">
                    <form method="POST" action="{{ route('rooms.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="home_type">Home type</label>
                                    <select name="home_type" id="home_type" class="form-control{{ $errors->has('home_type') ? ' is-invalid' : '' }}" value="{{ old('home_type') }}">
                                        <option selected disabled>Select...</option>
                                        @foreach ($home_types as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>

                                    @include('partials.error', ['attr' =>'home_type'])
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="room_type">Room type</label>
                                    <select name="room_type" id="room_type" class="form-control{{ $errors->has('room_type') ? ' is-invalid' : '' }}">
                                        <option selected disabled>Select...</option>
                                        @foreach ($room_types as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>

                                    @include('partials.error', ['attr' =>'room_type'])
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="accommodate">Accommodate</label>
                                    <select name="accommodate" id="accommodate" class="form-control{{ $errors->has('accommodate') ? ' is-invalid' : '' }}">
                                        <option selected disabled>Select...</option>

                                        @foreach ($count_options as $key => $option)
                                            <option value="{{ $key }}">{{ $option }}</option>
                                        @endforeach
                                    </select>

                                    @include('partials.error', ['attr' =>'accommodate'])
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bedroom_count">Bedrooms</label>
                                    <select name="bedroom_count" id="bedroom_count" class="form-control{{ $errors->has('bedroom_count') ? ' is-invalid' : '' }}">
                                        <option selected disabled>Select...</option>
                                        @foreach ($count_options as $key => $option)
                                            <option value="{{ $key }}">{{ $option }}</option>
                                        @endforeach
                                    </select>

                                    @include('partials.error', ['attr' =>'bedroom_count'])
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bathroom_count">Bathrooms</label>
                                    <select name="bathroom_count" id="bathroom_count" class="form-control{{ $errors->has('bathroom_count') ? ' is-invalid' : '' }}">
                                        <option selected disabled>Select...</option>
                                        @foreach ($count_options as $key => $option)
                                            <option value="{{ $key }}">{{ $option }}</option>
                                        @endforeach
                                    </select>

                                    @include('partials.error', ['attr' =>'bathroom_count'])
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
@endsection