@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials.room_menu')
            </div>
            <div class="col-md-9">
                <div class="card profile">
                    <div class="card-header">Ameneties</div>
                    <div class="card-body">
                        <div class="container container-small">
                            <form method="POST" action="{{ route('rooms.update', $room) }}">
                                @csrf
                                @method('PATCH')

                                <div class="row form-group mb-4">
                                    <div class="col-md-4">
                                        @include('partials.form.checkbox', [
                                            'name' => 'has_tv',
                                            'value' => old('has_tv') ?? $room->has_tv
                                        ])
                                        <label for="has_tv">TV</label>
                                    </div>

                                    <div class="col-md-4">
                                        @include('partials.form.checkbox', [
                                            'name' => 'has_kitchen',
                                            'value' => old('has_kitchen') ?? $room->has_kitchen
                                        ])
                                        <label for="has_kitchen">Kitchen</label>
                                    </div>

                                    <div class="col-md-4">
                                        @include('partials.form.checkbox', [
                                            'name' => 'has_aircon',
                                            'value' => old('has_aircon') ?? $room->has_aircon
                                        ])
                                        <label for="has_aircon">Air conditioning</label>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        @include('partials.form.checkbox', [
                                            'name' => 'has_heating',
                                            'value' => old('has_heating') ?? $room->has_heating
                                        ])
                                        <label for="has_heating">Heating</label>
                                    </div>

                                    <div class="col-md-4">
                                        @include('partials.form.checkbox', [
                                            'name' => 'has_internet',
                                            'value' => old('has_internet') ?? $room->has_internet
                                        ])
                                        <label for="has_internet">Internet</label>
                                    </div>
                                </div>

                                <div class="text-center mt-5">
                                    <button type="center" class="btn btn-form">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection