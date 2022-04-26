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
            'username' => 'required|max:255|min:3',
            'email' => 'required|email|max:255',
            'password' => 'required|max:255|min:7' // or ['required', 'min:7', 'max:255']
        ]);

        User::create($attributes);

        return redirect('/');
    }
}
