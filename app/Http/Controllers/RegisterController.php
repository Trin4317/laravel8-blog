<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
        // if the validation fails, Laravel will redirect to the previous page
        // and populate an error variable with associated validation errors
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:3|unique:users,username', // unique:[table],[column]
            // in case we need to add more complex logic for unique rule
            // 'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore($request->user()->id)],
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|max:255|min:7' // or ['required', 'min:7', 'max:255']
        ]);

        User::create($attributes);

        // flash method will store data in current session for the subsequent HTTP request and delete it after
        // session()->flash('success', 'Your account has been created.');

        return redirect('/')->with('success', 'Your account has been created.');
    }
}
