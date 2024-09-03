<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container">
                    <h1>Comparaison des prix</h1>
                    <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg">
                        <thead>
                            <tr>
                                <th>Concurrent / Réference</th>
                                @foreach ($references as $reference)
                                    <th class="px-6 py-4 whitespace">
                                        {{ $reference }} <br>
                                        <small>PVP: {{ $pvpProduits[$reference] }}€</small>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($concurrents as $concurrent)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $concurrent }}</td>
                                @foreach ($references as $reference)
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $tableauPrix[$concurrent][$reference] ?? 'N/A'}}€</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>