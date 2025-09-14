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
}
