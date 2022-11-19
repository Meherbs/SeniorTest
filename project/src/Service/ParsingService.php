<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParsingService
{
    private string $apiKey;

    private HttpClientInterface $client;

    public function __construct(string $apiKey, HttpClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    public function parse($url): array
    {
        $response = $this->client->request(
            'GET',
            str_replace('__news_api_key__' ,$this->apiKey, $url)
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        return $response->toArray()['articles'];
    }
}