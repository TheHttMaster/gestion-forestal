<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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

    /**
     * Ejecuta una consulta SQL en un dataset específico de la API.
     *
     * @param string $dataset Nombre del dataset (ej: 'umd_tree_cover_loss').
     * @param string $version Versión del dataset (ej: 'latest').
     * @param array $geometry Un arreglo de geometría GeoJSON para filtrar la consulta.
     * @param string $sql La consulta SQL a ejecutar.
     * @return array|null La respuesta decodificada de la API o null en caso de error.
     */
    public function executeQuery(string $dataset, string $version, array $geometry, string $sql): array
    {
        try {
            $response = $this->client->post("dataset/{$dataset}/{$version}/query", [
                'json' => [
                    'geometry' => $geometry,
                    'sql' => $sql
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (ClientException $e) {
            // Un error del lado del cliente (código 4xx)
            // Obtenemos la respuesta del servidor para ver el mensaje de error de la API.
            $responseBody = $e->getResponse()->getBody()->getContents();
            $errorData = json_decode($responseBody, true);

            $errorMessage = $errorData['message'] ?? 'Error de validación desconocido de la API.';
            Log::error("GFW API Error (HTTP {$e->getCode()}): {$errorMessage}");

            return [
                'status' => 'error',
                'message' => $errorMessage
            ];

        } catch (\Exception $e) {
            // Otros errores no relacionados con la API, como un problema de red.
            Log::error('GFW API Error inesperado: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'Ha ocurrido un error inesperado al conectar con la API.'
            ];
        }
    }

    /**
     * Obtiene la suma del área de pérdida de cobertura arbórea para un polígono y un año específicos.
     *
     * @param array $geometry
     * @param string $year
     * @return array|null
     */
    public function getZonalStats(array $geometry, int $year): ?array
    {
        $dataset = 'umd_tree_cover_loss';
        $version = 'latest';

        // Evita la interpolación de cadenas directamente.
        $sql = sprintf(
            "SELECT SUM(area__ha) FROM results WHERE umd_tree_cover_loss__year=%d",
            $year
        );

        return $this->executeQuery($dataset, $version, $geometry, $sql);
    }


    
}