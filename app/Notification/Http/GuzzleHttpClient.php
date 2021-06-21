<?php

namespace App\Notification\Http;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    private const TIMEOUT_SECONDS = 10;

    /** @var string[] */
    private $headers = [];

    /** @var string[] */
    private $queryParams = [];

    /** @var null|array */
    private $jsonPayload = null;

    public function setHeader(string $key, string $value): HttpClient
    {
        $new = clone $this;
        $new->headers[$key] = $value;

        return $new;
    }

    public function setJsonPayload(array $json): HttpClient
    {
        $new = clone $this;
        $new->jsonPayload = $json;

        return $new;
    }

    public function addQueryParam(string $key, string $value): HttpClient
    {
        $new = clone $this;
        $new->queryParams[$key] = $value;

        return $new;
    }

    public function post(string $url): HttpResponse
    {
        $response = $this->getClient()->post($url, $this->buildRequestOptions());

        return new SimpleHttpResponse($response->getStatusCode(), $response->getBody()->getContents());
    }

    private function buildRequestOptions(): array
    {
        $options = [
            'timeout' => self::TIMEOUT_SECONDS,
        ];

        if ($this->jsonPayload !== null) {
            $options['json'] = $this->jsonPayload;
        }

        if (count($this->headers) !== 0) {
            $options['headers'] = $this->headers;
        }

        if (count($this->queryParams) !== 0) {
            $options['query'] = $this->queryParams;
        }

        return $options;
    }

    private function getClient(): Client
    {
        return new Client(['http_errors' => false]);
    }
}