<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MailchimpNewsletter;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    // single action controller
    public function __invoke(MailchimpNewsletter $newsletter) // Concept: automatic resolution of dependency
                                                    // first Laravel checks Service Container
                                                    // there is Newsletter binding there so Laravel will resolve it the way it was defined
                                                    // newsletter route -> NewsletterController __invoke -> AppServiceProvider register -> Newsletter __construct
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
