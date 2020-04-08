<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    protected $error;

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated()
    {
        toastr()->success('You are now logged in!');
    }

    public function sendFailedLoginResponse()
    {
        if ($this->emailNotFound()) {
            $error = 'Please try another email or Sign up for an account.';
            $rules = [$this->username() => $error];
        }

        toastr()->error('Invalid credentials.');

        throw ValidationException::withMessages($rules ?? []);
    }

    public function loggedOut()
    {
        toastr()->info('You are now logged out.');
    }

    private function emailNotFound()
    {
        return is_null(\App\User::where('email', request()->email)->first());
    }
}
