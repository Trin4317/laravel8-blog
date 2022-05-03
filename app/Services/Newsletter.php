<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class newsletter
{
    public function __construct(protected ApiClient $client, protected string $foo) // dependency injection
                                                    // in case dependency requires a specific value that Laravel can't solve by itself
                                                    // we need to be explicit about how to instantiate Newsletter in Service Provider
    {
        // $this->client and $this->foo will be available after instantiated
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
