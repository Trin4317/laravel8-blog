<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\UserCreated;

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

        $user = User::create($attributes);

        // fire the event
        // Note 1: We can also fire the event from inside User class using $dispatchesEvents property

        // Note 2: At the moment, we are handling the event synchronously,
        // which means only after a Welcome mail is sent to the user's email address
        // then we log the user in and redirect back to homepage.
        // As a result, user has to wait until the event is handled completely.

        // Note 3: After enable Queue on event listener,
        // user now will be logged in and redirected back immediately
        // after the event is successfully put on the queue.
        // It's up to the queue worker to handle the job after.
        event(new UserCreated($user));

        // log the user in
        auth()->login($user);

        // flash method will store data in current session for the subsequent HTTP request and delete it after
        // session()->flash('success', 'Your account has been created.');

        return redirect('/')->with('success', 'Your account has been created.');
    }
}
