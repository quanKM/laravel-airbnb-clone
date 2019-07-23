@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('partials.room_menu')
            </div>
            <div class="col-md-9">
                <div class="card profile">
                    <div class="card-header">Photos</div>
                    <div class="card-body">
                        <div class="container container-small">
                            <div class="row">
                                <div class="col-md-6 m-auto">
                                    <form action="{{ route('rooms.photos.store', $room) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group text-center">
                                            <span class="btn btn-default btn-file w-100">
                                                Select Photos <i class="fa fa-images"></i>
                                                <input type="file" name="photos[]" id="" multiple="multiple">
                                            </a>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-form">
                                                <i class="fa fa-upload mr-2"></i>Add Photos
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if ($room->photos->isNotEmpty())
                                <hr>
                                <div class="photos mt-4">
                                    <div class="row">
                                        @foreach ($room->photos as $photo)
                                            <div class="col-md-4 mb-4">
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <img
                                                            src="{{ asset($photo->path("medium")) }}"
                                                            alt="{{ $room->listing_name }}"
                                                            class="card-img-top">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection