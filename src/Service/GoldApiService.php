<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoldApiService
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $goldApiKey,
    ) {
    }

    public function getXauUsd(): array
    {
        // URL should be dynamic
        $response = $this->httpClient->request('GET', 'https://www.goldapi.io/api/XAU/USD', [
            'headers' => [
                'x-access-token' => $this->goldApiKey,
                'Accept' => 'application/json',
            ],
        ]);

        return $response->toArray();
    }
}