@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <form action="" autocomplete="off">
                <div class="mb-4 input-group-lg">
                    <input type="text" class="form-control" name="address" placeholder="Anywhere" value="{{ old('address') }}">
                </div>
                <div class="text-center">
                    <button type="button" id="filter" class="btn btn-default" data-toggle="collapse" data-target="#collapsePanel">More filters
                        <i class="fa fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse" id="collapsePanel">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">Price range:</label>
                            <div id="slider"></div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Min Price:</label>
                                <input type="text" class="form-control" name="min_price">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Max Price:</label>
                                <input type="text" class="form-control" name="max_price">
                            </div>
                        </div>
                    </div>

                    <hr/>

                    <div class="row">
                        <div class="col-md-6 input-group-lg">
                            <input type="text" class="form-control text-center" id="start_date" name="start_date" placeholder="Start Date">
                        </div>
                        <div class="col-md-6 input-group-lg">
                            <input type="text" class="form-control text-center" id="end_date" name="end_date" placeholder="End Date">
                        </div>
                    </div>

                    <hr/>

                    {{-- Room Type --}}
                    <div class="row">
                        @foreach ($room_types as $room_name => $room_value)
                            <div class="col-md-4">
                                <div class="form-group">
                                    @include('partials.form.checkbox', [
                                        'name' => $room_name,
                                        'value' => old($room_name)
                                    ])
                                    <label class="align-text-top" for="{{ $room_name }}">{{ $room_value }}</label>
                                </div>
                            </div>
                        @endforeach                            
                    </div>

                    <hr>

                    {{-- Accommodate Count --}}
                    <div class="row">
                        @foreach ($count_types as $count_name => $count_value)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="{{ $count_name }}">{{ $count_value }}</label>

                                    @include('partials.form.select', [
                                        'name' => $count_name,
                                        'options' => $count_options,
                                        'selected' => old($count_name)
                                    ])
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    {{-- Amenities --}}
                    <div class="row form-group mb-4">
                        @foreach ($amenities as $amenity_name => $amenity_value)
                            <div class="col-md-4">
                                @include('partials.form.checkbox', [
                                    'name' => $amenity_name,
                                    'value' => old($amenity_name)
                                ])
                                <label for="{{ $amenity_name }}">{{ $amenity_value }}</label>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <div class="row justify-content-center">
                        <button class="btn btn-form" type="submit">Search</button>
                    </div>
                </div>
                <br>
            </form>
        </div>
        
        <div>
    
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $( "#slider" ).slider();
    });
</script>
<script>
    $('#start_date').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0,
        maxDate: '3m',
        onSelect: function(selected) {
            $('#end_date').datepicker("option", "minDate", selected);
        }
    });
    $('#end_date').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0,
        maxDate: '3m',
        onSelect: function(selected) {
            $('#start_date').datepicker("option", "maxDate", selected);
        }
    });
</script>
@endsection