<?php

namespace App\Services;

interface Newsletter
{
    // define a contract that any implement of this interface must follow
    public function subscribe(string $email, string $list = null);

}
