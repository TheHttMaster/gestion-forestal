<!-- resources/views/deforestation/multiple-results.blade.php -->
<x-app-layout>
<div class="max-w-7xl mx-auto ">
    <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 mb-6">
        <div class="text-gray-900 dark:text-gray-100 ">
            <h2 class="font-semibold text-xl leading-tight mb-6">
                {{('Resultados del Análisis Múltiple') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 ">
                @foreach($polygons as $polygon)
                <div class="bg-white dark:bg-custom-gray3 rounded-xl shadow-md overflow-hidden border border-gray-800">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $polygon->name }}</h5>
                    </div>
                    <div class="p-6">
                        <div class="space-y-2 mb-4">
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong class="text-gray-900 dark:text-white">Área total:</strong> 
                                {{ number_format($polygon->area_ha, 2) }} ha
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong class="text-gray-900 dark:text-white">Pérdida total:</strong> 
                                <span class="text-red-600 font-medium">
                                    {{ number_format($polygon->analyses->last()->deforested_area_ha, 2) }} ha
                                </span>
                            </p>
                        </div>
                        <a href="{{ route('deforestation.results', $polygon->id) }}" 
                        class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Ver detalles completos
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>   
     
    
    <div class="bg-stone-100/90 dark:bg-custom-gray overflow-hidden shadow-sm sm:rounded-2xl shadow-soft p-4 md:p-6 lg:p-8 mb-6">
        <div class="text-gray-900 dark:text-gray-100 ">
            <h2 class="font-semibold text-xl leading-tight mb-6">
                {{('Resumen General') }}
            </h2>
        
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-custom-gray3">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Polígono</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Área Total (ha)</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Pérdida Total (ha)</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">% Pérdida</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($polygons as $polygon)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $polygon->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ number_format($polygon->area_ha, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600">{{ number_format($polygon->analyses->last()->deforested_area_ha, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600">{{ number_format($polygon->analyses->last()->percentage_loss, 2) }}%</td>
                        </tr>
                        @endforeach
                        <tr class="bg-gray-50 dark:bg-zinc-800 font-semibold">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">TOTAL</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ number_format($polygons->sum('area_ha'), 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600">{{ number_format($polygons->sum(function($polygon) { return $polygon->analyses->last()->deforested_area_ha; }), 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600">
                                @php
                                    $totalArea = $polygons->sum('area_ha');
                                    $totalLoss = $polygons->sum(function($polygon) { return $polygon->analyses->last()->deforested_area_ha; });
                                    $totalPercentage = $totalArea > 0 ? ($totalLoss / $totalArea) * 100 : 0;
                                @endphp
                                {{ number_format($totalPercentage, 2) }}%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
   
</div>
</x-app-layout>