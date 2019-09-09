@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7 my-5">
            <h1><span class="text-primary">Sunbnb</span> Book unique homes and experience a city like a local</h1>
        </div>
    </div>

    <form action="" autocomplete="off">
        <div class="row">
            <div class="col-md-6 input-group-lg">
                <input class="form-control" name="address" type="text" placeholder="Where are you going?">
            </div>
            <div class="col-md-3 input-group-lg">
                <input class="form-control text-center" id="start_date" name="start_date" type="text" placeholder="Start Date">
            </div>
            <div class="col-md-3 input-group-lg">
                <input class="form-control text-center" id="end_date" name="end_date" type="text" placeholder="End Date">
            </div>
        </div>

        <br/><br/>

         <div class="row">
            <div class="offset-md-4 col-md-4">
                <button type="submit" class="btn btn-normal btn-lg btn-block">Search</button>
            </div>
        </div>
    </form>

    <br/><hr/><br/>

    <div><h3>Homes</h3></div>

    <br/>

    <div class="row">
        @include('rooms.partials.room_list')
    </div>

    <br>

    <div><h3>Cities</h3></div>

    <div class="row">
        <div class="col-md-3 col-sm-12">
            <a href="">
                <img class="w-100" src="/images/LA.jpg" alt="">
            </a>
        </div>
        <div class="col-md-3 col-sm-12">
            <a href="">
                <img class="w-100" src="/images/LD.jpg" alt="">
            </a>
        </div>
        <div class="col-md-3 col-sm-12">
            <a href="">
                <img class="w-100" src="/images/PR.jpg" alt="">
            </a>
        </div>
        <div class="col-md-3 col-sm-12">
            <a href="">
                <img class="w-100" src="/images/MI.jpg" alt="">
            </a>
        </div>
    </div>
@endsection

@section('scripts')
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