<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GFWService;


class ForestController extends Controller
{
    protected $gfwService;

    public function __construct(GFWService $gfwService)
    {
        $this->gfwService = $gfwService;
    }

    public function showStats()
    {
        // Define tu geometría GeoJSON y el año
        $geometry = [
            'type' => 'Polygon',
            'coordinates' => [[
                [
                    -63.18378116560976,
                    10.563060285040407
                  ],
                  [
                    -63.18669994025022,
                    10.55421721571689
                  ],
                  [
                    -63.18014733390075,
                    10.552596248333586
                  ],
                  [
                    -63.17912460941018,
                    10.562386593151615
                  ],
                  [
                    -63.18378116560976,
                    10.563060285040407
                  ]
            ]]
        ];

        $year = '2020';

        $stats = $this->gfwService->getZonalStats($geometry, $year);

        dd($stats);

        // Pasa los datos a tu vista
        if ($stats) {
            return view('stats.show', ['stats' => $stats]);
        }

        // Maneja el caso en que la petición falló
        return view('stats.error');
    }

    public function showRADDAlerts()
    {
        // Define el área de interés y el rango de fechas
        $geometry = [
            'type' => 'Polygon',
            'coordinates' => [[
                [
					-63.18377729271269,
					10.563102208974854
				  ],
				  [
					-63.18601093182674,
					10.555033032154896
				  ],
				  [
					-63.17980032550888,
					10.554158263536166
				  ],
				  [
					-63.1789286614643,
					10.562388131075139
				  ],
				  [
					-63.18377729271269,
					10.563102208974854
				  ]
            ]]
        ];

        $startDate = '2020-01-01';
        $endDate = '2024-06-30';

        // Llama al nuevo método del servicio
        $alerts = $this->gfwService->getRADDAlertsByDate($geometry, $startDate, $endDate);

        // Muestra las alertas para verificar la respuesta
        dd($alerts);
    }
}
