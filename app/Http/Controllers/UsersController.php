<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\GuestReview;
use App\HostReview;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(User $user)
    {
        $guestReviews = GuestReview::where('host_id', $user->id)
                                    ->where('type', 'GuestReview')
                                    ->get();

        $hostReviews = HostReview::where('guest_id', $user->id)
                                  ->where('type', 'HostReview')
                                  ->get();

        return view('users.show', compact('user', 'hostReviews', 'guestReviews'));
    }

    public function edit()
    {
        $user = auth()->user();

        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user())],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];

        $validator = Validator::make(
            $request->all(),
            $rules
        );

        if ($validator->fails()) {
            toastr()->error('There are error(s) in your submission');

            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->valid();

        // Remove password if not set
        if (is_null(request()->password)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        auth()->user()->fill($data);
        auth()->user()->save();

        toastr()->success('Updated successfully');

        return redirect()->route('user.edit');
    }
}
