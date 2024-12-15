<?php

namespace App\Application\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WordPressService
{
    private $client;
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = $_ENV['WP_API_URL'] ?? 'http://localhost:8080/wp-json'; // TODO: change the approach.

        $this->client = new Client([
            'timeout' => 5,
            'verify' => false
        ]);
    }

    public function getPosts()
    {
        try {
            $url = $this->baseUrl . '/wp/v2/posts';
            error_log('Attempting to fetch posts from: ' . $url);

            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);

            $body = $response->getBody()->getContents();
            $posts = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Failed to parse JSON: ' . json_last_error_msg());
            }

            return $posts;

        } catch (GuzzleException $e) {
            error_log('WordPress API Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
