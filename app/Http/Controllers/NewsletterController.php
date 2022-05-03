<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Newsletter;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    // single action controller
    public function __invoke(Newsletter $newsletter) // Concept: automatic resolution of dependency
                                                    // newsletter route -> NewsletterController __invoke -> AppServiceProvider register -> Newsletter __construct
                                                    // Controller doesn't care what service for newsletter
                                                    // and let AppServiceProvider decide
    {
        request()->validate([
            'email' => 'required|email'
        ]);

        try {
            $newsletter->subscribe(request('email'));
        } catch (\Exception $e) { // global namespace for Exception
            throw ValidationException::withMessages([
                'email' => 'This email could not be added to our newsletter list.'
            ]);
        };

        return redirect('/')->with('success', 'You are now signed up for our newsletter');
    }
}
