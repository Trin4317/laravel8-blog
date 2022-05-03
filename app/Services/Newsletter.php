<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class newsletter
{
    public function subscribe(string $email)
    {
        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => config('services.mailchimp.server'),
        ]);

        return $client->lists->addListMember(config('services.mailchimp.list'), [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }
}
