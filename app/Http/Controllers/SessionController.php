<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('session.create');
    }

    public function store()
    {
        // validate the request
        $attributes = request()->validate([
            'email' => 'required|email', //'exists:user,email' is the opposite of unique constraint
                                        // but might also raise security issue
            'password' => 'required'
        ]);
        // attempt to authenticate and log in the user
        // based on the provided credentials
        if (auth()->attempt($attributes)) {
            // if user provides the correct credentials
            // then attemp() will also log user in

            // handle session fixation attack by regenerate the user's session
            session()->regenerate();

            // redirect with a success flash message
            return redirect('/')->with('success', 'Welcome back!');
        }

        // in case auth failed
        throw ValidationException::withMessages([
            'email' => 'Your provided credentials could not be verified.'
        ]);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye!');
    }
}
