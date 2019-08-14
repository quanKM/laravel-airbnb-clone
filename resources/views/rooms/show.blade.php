@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <img src="{{ $room->coverPhoto('original') }}" alt="cover-photo" width="100%">
        </div>
    </div>
    <br/>

    <div class="row">

         {{-- LEFT PANEL --}}
        <div class="col-md-8">

            {{-- Listing Name --}}
            <div class="row">
                <div class="col-md-8">
                    <h1>{{ $room->listing_name }}</h1>
                    {{ $room->address }}
                </div>

                <div class="col-md-4 text-center">
                    @if ($room->user->socialAccount)
                        <img src="{{ $room->user->socialAccount->image }}" class="rounded-circle" width="68px">
                    @else
                        <img src="{{ $room->user->gravatar(68) }}" class="rounded-circle">
                    @endif
                    <br/><br/>
                    {{ $room->user->name }}
                </div>
            </div>

            <hr/>

            {{-- Room Info --}}
            <div class="text-center">
                <div class="row my-1">
                    <div class="col-md-3 text-secondary">
                        <i class="fa fa-home fa-2x"></i>
                    </div>
                    <div class="col-md-3 text-secondary">
                        <i class="fa fa-user-circle fa-2x"></i>
                    </div>
                    <div class="col-md-3 text-secondary">
                        <i class="fa fa-bed fa-2x"></i>
                    </div>
                    <div class="col-md-3 text-secondary">
                        <i class="fa fa-bath fa-2x"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 text-secondary">{{ $room->home_type }}</div>
                    <div class="col-md-3 text-secondary">{{ $room->accommodate }} {{ str_plural("Guest", $room->accommodate) }}</div>
                    <div class="col-md-3 text-secondary">{{ $room->bedroom_count }} {{ str_plural("Bedroom", $room->bedroom_count) }}</div>
                    <div class="col-md-3 text-secondary">{{ $room->bathroom_count }} {{ str_plural("Bathroom", $room->bathroom_count) }}</div>
                </div>
            </div>

            <hr/>

            {{-- About --}}
            <div class="row">
                <div class="col-md-12">
                    <h3>About This Listing</h3>
                    <p>{{ $room->summary }}</p>
                </div>
            </div>

            <hr/>

            {{-- Ameneties --}}
            <div class="row">
                <div class="col-md-3">
                    <h4>Amenities</h4>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="amenities">
                                <li class="mb-1 {{ $room->has_tv ? '' : 'text-line-through small' }}">TV</li>
                                <li class="mb-1 {{ $room->has_kitchen ? '' : 'text-line-through small' }}">Kitchen</li>
                                <li class="mb-1 {{ $room->has_internet ? '' : 'text-line-through small' }}">Internet</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="amenities">
                                <li class="mb-1 {{ $room->has_heating ? '' : 'text-line-through small' }}">Heating</li>
                                <li class="mb-1 {{ $room->has_aircon ? '' : 'text-line-through small' }}">Air Conditioning</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            {{-- Carousel --}}
            <div class="row">
                @if ($room->photos->count() > 0)
                    <div id="carouselSlide" class="carousel slide w-100" data-ride="carousel">

                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            @foreach ($room->photos as $photo)
                                <li data-target="#carouselSlide" data-slide-to="{{ $photo->id }}"></li>
                            @endforeach
                        </ul>

                        <!-- The slideshow -->
                        <div class="carousel-inner">
                            @foreach ($room->photos as $photo)
                                <div class="carousel-item {{ $photo->id == $room->photos[0]->id ? 'active' : '' }}">
                                    <img src="{{ Storage::disk('s3')->url($photo->path("original")) }}" class="d-block w-100">
                                </div>
                            @endforeach
                        </div>

                        <!-- Left and right controls -->
                       <a class="carousel-control-prev" href="#carouselSlide" data-slide="prev">
                           <span class="carousel-control-prev-icon"></span>
                       </a>
                       <a class="carousel-control-next" href="#carouselSlide" data-slide="next">
                           <span class="carousel-control-next-icon"></span>
                       </a>

                    </div>
                @endif
            </div>

            <hr/>

            {{-- Google Map --}}
            <div class="row">
                <div id="map" class="w-100" style="height: 400px">
                </div>
            </div>

            <hr/>

            {{-- Nearby Rooms --}}
            <div>
                <h3>Near by</h3>
                <div class="row">
                    @foreach ($room->nearbys(10) as $nearbyRoom)
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-image-top w-100" src="{{ $nearbyRoom->coverPhoto('medium') }}">
                                <div class="card-body">
                                    <a href="{{ route('rooms.show', $nearbyRoom) }}">{{ $nearbyRoom->listing_name }}</a>
                                    <br/>
                                    ({{ round($nearbyRoom->distance, 2) }} kms away)
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="col-md-4 reservation-form">
            {{-- RESERVATION FORM --}}
            <div class="card profile">
                <div class="card-header">
                    <span><i class="fa fa-bolt"></i> ${{ $room->price }}</span>
                    <span class="float-right">Per Night</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('rooms.reservations.store', $room) }}" method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <label for="start_date">Check In</label>
                                <input
                                    class="form-control datepicker" type="text"
                                    name="start_date" id="start_date"
                                    placeholder="Start Date">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date">Check Out</label>
                                <input
                                    class="form-control datepicker" type="text"
                                    name="end_date" id="end_date"
                                    placeholder="End Date" disabled>
                            </div>
                        </div>

                        <h4 class="invalid-feedback d-block text-center"><span id="message"></span></h4>
                        {{-- Preview --}}
                        <div id="preview" style="display: none">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Price</td>
                                        <td>${{ $room->price }}</td>
                                    </tr>
                                    <tr>
                                        <td>Night(s)</td>
                                        <td>x <span id="reservation_nights"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="total">Total</td>
                                        <td>$<span id="reservation_total"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <br/>
                        <div class="form-group">
                            <button id="btn_book" class="btn btn-normal btn-block" type="submit" disabled>Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.api_key') }}"></script>
<script>
    function initialize() {
        var location = {lat: {{ $room->latitude }}, lng: {{ $room->longitude }}};

        var map = new google.maps.Map(document.getElementById('map'), {
            center: location,
            zoom: 14
        });

        var marker = new google.maps.Marker({
            position: location,
            map: map
        });

        var infoWindow = new google.maps.InfoWindow({
            content: "<div id='content'><img src='{{ $room->coverPhoto('medium') }}'></div>"
        });

        infoWindow.open(map, marker);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>    
<script>
    function checkDate(date) {
        ymd = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
        return [$.inArray(ymd, unavailableDates) == -1];
    };

    function checkPreview() {
        var start_date = $.datepicker.formatDate('yy-mm-dd', $('#start_date').datepicker('getDate'));
        var end_date = $.datepicker.formatDate('yy-mm-dd', $('#end_date').datepicker('getDate'));
        var nights = (new Date(end_date) - new Date(start_date))/1000/60/60/24 + 1;

        if (end_date) {
            $.ajax({
                type: "GET",
                url: "{{ route('rooms.preview', $room) }}",
                data: {
                    'start_date': start_date,
                    'end_date': end_date
                },
                success: function(data) {
                    if (data.conflict) {
                        $('#message').text('These dates are not available');
                        $('#preview').hide();
                        $('#btn_book').attr('disabled', true);
                    } else {
                        $('#message').text('');
                        $('#preview').show();
                        $('#btn_book').attr('disabled', false);

                        var total = nights * {{ $room->price }};
                        $('#reservation_nights').text(nights);
                        $('#reservation_total').text(total);
                    }
                }
            });
        }
    };

    $(function() {
        unavailableDates = [];

        $.ajax({
            type: "GET",
            url: "{{ route('rooms.preload', $room) }}",
            success: function(data) {
                $.each(data, function(key, value){
                    for(var date = new Date(value.start_date); date <= new Date(value.end_date); date.setDate(date.getDate() + 1)) {
                        unavailableDates.push($.datepicker.formatDate('yy-m-d', date));
                    }
                });

                $('#start_date').datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: 0,
                    maxDate: '3m',
                    beforeShowDay: checkDate,
                    onSelect: function(selected) {
                        $('#end_date').datepicker('option', 'minDate', selected);
                        $('#end_date').attr('disabled', false);

                        checkPreview();
                    }
                });

                $('#end_date').datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: 0,
                    maxDate: '3m',
                    beforeShowDay: checkDate,
                    onSelect: function(selected) {
                        $('#start_date').datepicker('option', 'maxDate', selected);

                        checkPreview();
                    }
                });
            }
        });
    })
</script>
@endsection