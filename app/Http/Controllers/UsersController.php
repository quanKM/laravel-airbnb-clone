<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user())],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        // Remove password if not set
        if (is_null(request()->password)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        auth()->user()->fill($data);
        auth()->user()->save();

        return redirect(route('user.edit'));
    }
}
