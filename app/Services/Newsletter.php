<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class newsletter
{
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

    protected function client() // construction injection
    {
        $client = new ApiClient();

        return $client->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => config('services.mailchimp.server'),
        ]);
    }
}
