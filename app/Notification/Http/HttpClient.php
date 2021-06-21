<?php

namespace App\Notification\Http;

interface HttpClient
{
    public function setHeader(string $key, string $value): self;

    public function setJsonPayload(array $json): self;

    public function addQueryParam(string $key, string $value): self;

    public function post(string $url): HttpResponse;
}