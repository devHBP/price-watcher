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


<h2 class="text-lg font-bold mb-4">Produits</h2>
<div class="flex flex-wrap space-x-2">
    <template x-for="produit in produits" :key="produit.id">
        <button
            @click="selectedProduct = produit.id; fetchHistoricalData()"
            x-bind:class="{ 'bg-blue-500 text-white': selectedProduct === produit.id, 'bg-gray-200 text-black': selectedProduct !== produit.id }"
            class="m-2 px-4 py-2 rounded-full cursor-pointer"
        >
            <span x-text="produit.designation"></span>
        </button>
    </template>
</div>
</div>  