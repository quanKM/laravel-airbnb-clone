@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center">Profile</h2>

            <form method="POST" action="{{ route('user.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <input id="name" type="text"  name="name"
                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                        placeholder="Full name"
                        value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus>

                    @include('partials.error', ['attr' => 'name'])
                </div>

                <div class="form-group">
                    <input id="email" type="email" name="email"
                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                        placeholder="Email"
                        value="{{ old('email') ?? $user->email }}" required autocomplete="email">

                    @include('partials.error', ['attr' => 'email'])
                </div>

                <div class="form-group">
                    <small class="ml-1"><em>(6 characters minimum)</em></small>
                    <input id="password" type="password" name="password"
                        class="mt-1 form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                        placeholder="Password" autocomplete="new-password">

                    @include('partials.error', ['attr' => 'password'])
                </div>

                <div class="form-group">
                    <input id="password-confirm" type="password" name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm password" autocomplete="new-password">
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
