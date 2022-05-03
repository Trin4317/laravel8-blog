<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Newsletter;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    // single action controller
    public function __invoke(Newsletter $newsletter) // Concept: automatic resolution of dependency
                                                    // first Laravel checks Service Container
                                                    // but there is no Newsletter dependency so Laravel will try to create one
    {
        request()->validate([
            'email' => 'required|email'
        ]);

        try {
            $newsletter->subscribe(request('email'));
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'This email could not be added to our newsletter list.'
            ]);
        };

        return redirect('/')->with('success', 'You are now signed up for our newsletter');
    }
}
