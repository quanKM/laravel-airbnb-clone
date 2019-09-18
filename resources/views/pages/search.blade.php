@extends('layouts.app')

@section('content')
<div class="container search">
    <div class="row filters">
        <div class="text-center">
            <form action="{{ route('search') }}" autocomplete="off">
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
                                <input type="text" class="form-control" id="min_price" name="min_price" value="{{ old('min_price') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Max Price:</label>
                                <input type="text" class="form-control" id="max_price" name="max_price" value="{{ old('max_price') }}">
                            </div>
                        </div>
                    </div>
                    <hr/>

                    <div class="row">
                        <div class="col-md-6 input-group-lg">
                            <input type="text" class="form-control text-center" id="start_date" name="start_date" placeholder="Start Date" value={{ old('start_date') }}>
                        </div>
                        <div class="col-md-6 input-group-lg">
                            <input type="text" class="form-control text-center" id="end_date" name="end_date" placeholder="End Date" value="{{ old('end_date') }}">
                        </div>
                    </div>

                    <hr/>

                    {{-- Room Type --}}
                    <div class="row">
                        @foreach ($room_types as $room_name => $room_value)
                            <div class="col-md-4">
                                <div class="form-group">
                                    @include('partials.form.checkbox', [
                                        'name' => "room_type[{$room_name}]",
                                        'value' => old("room_type.$room_name")
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
                    <div class="row form-group mb-4 text-left">
                        @foreach ($amenities as $amenity_name => $amenity_value)
                            <div class="col-md-4">
                                @include('partials.form.checkbox', [
                                    'name' => "amenities[{$amenity_name}]",
                                    'value' => old("amenities.$amenity_name")
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
            </form>
        
            <br>

            <div class="row">
                @include('rooms.partials.room_list')
            </div>
        </div>
    </div>

    <div class="map">
        <div id="map" class="w-100 h-100"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $( "#slider" ).slider();

        var open = false;

        $('#filter').click(function() {
            if (open) {
                $('#filter').html("More filters <i class='fa fa-chevron-down'></i>")
            } else {
                $('#filter').html("More filters <i class='fa fa-chevron-up'></i>")
            }
            open = !open;
        });
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.api_key') }}"></script>
<script>
    function initialize(rooms) {
        var location = {lat: 10.315699, lng: 123.88547};

        if (rooms.length > 0) {
            location = { lat: rooms[0].latitude, lng: rooms[0].longitude }
        }

        var map = new google.maps.Map(document.getElementById('map'), {
            center: location,
            zoom: 12
        });

        var marker, infowindow;

        for (room of rooms) {
            marker = new google.maps.Marker({
                position: { lat: room.latitude, lng: room.longitude },
                map: map
            });
            infowindow = new google.maps.InfoWindow({
                content: "<div class='room-price'>$" + room.price + "</div>"
            });
            infowindow.open(map, marker);
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize(@json($rooms)));
</script>
<script>
    $(function() {
        $("#min_price").val('100');
        $("#max_price").val('500');
        $("#slider").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [100, 500],
            slide: function(event, ui) {
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
            }
        });
        $('.ui-widget-header').css('background', '#00A699');
        $('.ui-state-default, .ui-widget-content').css('background', 'white');
        $('.ui-state-default, .ui-widget-content').css('border-color', '#00A699');
    });
</script>
@endsection