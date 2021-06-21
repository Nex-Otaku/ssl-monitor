<?php

namespace App\Notification\Http;

interface HttpResponse
{
    public function getStatusCode(): int;

    public function getBody(): string;
}