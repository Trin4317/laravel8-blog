<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class MailchimpNewsletter
{
    public function __construct(protected ApiClient $client) // dependency injection
    {
        // $this->client will be available after instantiated
    }

    public function subscribe(string $email, string $list = null)
    {
        // null coalescing operator
        // equivalent to $list = isset($list) ? $list : config();
        $list ??= config('services.mailchimp.list');

        return $this->client->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }
}
