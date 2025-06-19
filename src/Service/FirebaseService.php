<?php

// src/Service/FirebaseService.php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FirebaseService
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(HttpClientInterface $httpClient, string $firebaseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $firebaseUrl;
    }

    public function pushToDatabase(string $path, array $data): void
    {
        $url = $this->baseUrl . '/' . $path . '.json';
        $this->httpClient->request('POST', $url, [
            'json' => $data,
        ]);
    }
}