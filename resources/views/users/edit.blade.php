@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <ul class="list-unstyled sidebar">
                <li>
                    <a href="{{ route('user.edit') }}">Edit Profile</a>
                </li>
            </ul>
            <a href="{{ route('users.show', Auth::user()) }}"
                class="btn btn-default btn-block mt-5">View my profile</a>
        </div>
        <div class="col-md-9">
            <div class="card profile">
                <div class="card-header text-center">Your Profile</div>
                <div class="card-body">
                    <div class="container container-small">
                        <form method="POST" action="{{ route('user.update') }}">
                            @csrf
                            @method('PATCH')
            
                            <div class="form-group">
                                <input id="name" type="text"  name="name"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="Full name"
                                    value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus>
            
                                @include('partials.error', ['attr' => 'name'])
                            </div>
            
                            <div class="form-group">
                                <input id="email" type="email" name="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="Email"
                                    value="{{ old('email') ?? $user->email }}" required autocomplete="email">
            
                                @include('partials.error', ['attr' => 'email'])
                            </div>
            
                            <div class="form-group">
                                <input id="phone_number" type="text" name="phone_number"
                                    class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                    placeholder="Phone no."
                                    value="{{ old('phone_number') ?? $user->phone_number }}" required autocomplete="phone_number">
            
                                @include('partials.error', ['attr' => 'phone_number'])
                            </div>
            
                            <div class="form-group">
                                <textarea
                                    name="description"
                                    id="description" class="form-control"
                                    placeholder="Description"
                                    cols="25" rows="5">{{ old('description') ?? $user->description }}</textarea>
            
                                @include('partials.error', ['attr' => 'description'])
                            </div>
            
                            <div class="form-group">
                                <small class="ml-1"><em>(6 characters minimum)</em></small>
                                <input id="password" type="password" name="password"
                                    class="mt-1 form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    placeholder="Password" autocomplete="new-password">
            
                                @include('partials.error', ['attr' => 'password'])
                            </div>
            
                            <div class="form-group">
                                <input id="password-confirm" type="password" name="password_confirmation"
                                    class="form-control"
                                    placeholder="Confirm password" autocomplete="new-password">
                            </div>
            
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-normal btn-block">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
