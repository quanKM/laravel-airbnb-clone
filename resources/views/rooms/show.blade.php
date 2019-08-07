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
        </div>

        {{-- RIGHT PANEL --}}
        <div class="col-md-4">
            {{-- RESERVATION FORM --}}
        </div>
    </div>
</div>
@endsection