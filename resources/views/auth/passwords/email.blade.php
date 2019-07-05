@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center">Reset Passwords</h2>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <input id="email" type="email" name="email"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        placeholder="Email address"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @include('partials.error', ['attr' => 'email'])
                </div>

                <div class="form-group mb-0">
                    <div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Send Password Reset Links
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
