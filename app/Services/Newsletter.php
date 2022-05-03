<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class newsletter
{
    public function __construct(protected ApiClient $client) // dependency injection
                                                    // which means when instantiate Newsletter we also need ApiClient dependency
                                                    // Laravel will call 'new Newsletter(new ApiClient)' behind the scene
    {
        // $this->client will be available when calling Newsletter
    }

    public function subscribe(string $email, string $list = null)
    {
        // null coalescing operator
        // equivalent to $list = isset($list) ? $list : config();
        $list ??= config('services.mailchimp.list');

        return $this->client()->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }

    protected function client()
    {
        return $this->client->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => config('services.mailchimp.server'),
        ]);
    }
}
