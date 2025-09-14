<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GFWService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('GFW_API_BASE_URI'),
            'timeout'  => 10.0,
            'headers'  => [
                'x-api-key' => env('GFW_API_KEY'),
            ]
        ]);
    }

    public function getZonalStats(array $geometry, string $year)
    {
        try {
            $response = $this->client->post('dataset/umd_tree_cover_loss/latest/query', [
                'json' => [
                    'geometry' => $geometry,
                    'sql' => "SELECT SUM(area__ha) FROM results WHERE umd_tree_cover_loss__year=$year"
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Maneja errores de cliente, como 400 Bad Request o 404 Not Found
            Log::error('GFW API Client Error: ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Maneja otros errores
            Log::error('GFW API Error: ' . $e->getMessage());
            return null;
        }
    }
}