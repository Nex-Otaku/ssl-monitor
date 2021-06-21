<?php

namespace App\Notification\Http;

class FakeHttpClient implements HttpClient
{
    private int $code = 200;

    private bool $needThrowException = false;

    public function withCode(int $code): self
    {
        $new = clone $this;
        $new->code = $code;

        return $new;
    }

    public function withException(): self
    {
        $new = clone $this;
        $new->needThrowException = true;

        return $new;
    }

    public function setHeader(string $key, string $value): HttpClient
    {
        // Ничего не делаем.

        return $this;
    }

    public function setJsonPayload(array $json): HttpClient
    {
        // Ничего не делаем.

        return $this;
    }

    public function addQueryParam(string $key, string $value): HttpClient
    {
        // Ничего не делаем.

        return $this;
    }

    public function post(string $url): HttpResponse
    {
        if ($this->needThrowException) {
            throw new \RuntimeException('Test exception for fake HTTP client');
        }

        return new SimpleHttpResponse($this->code, '');
    }
}