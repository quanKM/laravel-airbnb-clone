@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials.room_menu')
            </div>
            <div class="col-md-9">
                <div class="card profile">
                    <div class="card-header">Pricing</div>
                    <div class="card-body">
                        <div class="container container-small">
                            <form method="POST" action="{{ route('rooms.update', $room) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" name="price"
                                        value="{{ old('price') ?? $room->price }}"
                                        placeholder="eg: $100" required
                                        class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}">

                                    @include('partials.error', ['attr' => 'price'])
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