<?php

namespace App\Application\Services;

use GuzzleHttp\Client;

class GraphQLService
{
    private $client;
    private $endpoint;

    public function __construct()
    {
        if (!isset($_ENV['WP_API_URL'])) {
            throw new \RuntimeException('WordPress API URL not configured.');
        }

        // GraphQL endpoint is typically at /graphql
        $this->endpoint = str_replace('/wp-json', '/graphql', $_ENV['WP_API_URL']);

        $this->client = new Client([
            'timeout' => 5,
            'verify' => false
        ]);
    }

    public function query($query, $variables = [])
    {
        try {
            $response = $this->client->request('POST', $this->endpoint, [
                'json' => [
                    'query' => $query,
                    'variables' => $variables
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \RuntimeException('GraphQL query failed: ' . $e->getMessage());
        }
    }
}
