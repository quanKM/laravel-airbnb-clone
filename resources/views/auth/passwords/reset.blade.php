@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center">Reset Password</h2>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" name="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            placeholder="E-Mail Address"
                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('partials.error', ['attr' => 'email'])
                    </div>
                </div>

                <div class="form-group">
                    <input id="password" type="password" name="password"
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                        placeholder="Password"
                        required autocomplete="new-password">

                    @error('partials.error', ['attr' => 'password'])
                </div>

                <div class="form-group row">
                    <input id="password-confirm" type="password" name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm Password"
                        required autocomplete="new-password">
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
