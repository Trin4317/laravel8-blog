<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'user' => auth()->user()
        ]);
    }

    public function update()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore(auth()->user()->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(auth()->user()->id)],
            'avatar' => 'image'
        ]);

        // if user provides an avatar then update the avatar attribute to resource link
        if (isset($attributes['avatar'])) {
            $attributes['avatar'] = request()->file('avatar')->store('avatars');

            // remove old avatar from storage if the user has one
            if (!is_null(auth()->user()->avatar) && Storage::exists(auth()->user()->avatar)) {
                Storage::delete(auth()->user()->avatar);
            }
        }

        auth()->user()->update($attributes);

        return back()->with('success', 'Profile Updated!');
    }
}
