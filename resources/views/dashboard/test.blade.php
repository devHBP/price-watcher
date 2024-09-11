<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title -->
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __( $selectedProduit->designation ) }}
            </h2>
    
            <!-- PVP Display -->
            <div class="bg-blue-500 text-white rounded-full px-6 py-3 shadow-lg flex items-center space-x-3">
                <span class="text-lg font-bold">PVP: {{ number_format($selectedProduit->pvp, 2, ',', ' ') }} €</span>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col md:flex-row p-4 space-x-4">
        <!-- Panneau latéral pour les catégories (1/4 de l'espace) -->
        <div class="w-full md:w-1/4 bg-gray-100 p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-bold mb-4">Catégories</h2>
            <ul>
                @foreach($categories as $categorieProduit)
                    <li>
                        <a href="{{ route('dashboard.changeCategorie', $categorieProduit->id ) }}"
                           class="block w-full text-left p-2 rounded {{ $selectedCategorie->id == $categorieProduit->id ? 'bg-blue-500 text-white' : '' }}">
                            {{ $categorieProduit->nom }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Contenu principal (3/4 de l'espace) -->
        <div class="w-full md:w-3/4 bg-white p-4 rounded-lg shadow-md">
            <!-- Tableau pour les données historiques -->
            @if(!empty($historiquePrix))
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead class="bg-gray-200 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concurrents</th>
                                @foreach($historiquePrix['dates'] as $date)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $date }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($historiquePrix['structuredData'] as $concurrent => $data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $concurrent }}</td>
                                    @foreach($historiquePrix['dates'] as $date)
                                        @php
                                            $price = $data[$date] ?? '-';
                                            
                                            // Initialiser les variables
                                            $prevPrice = null;
                                            $currentDate = \Carbon\Carbon::createFromFormat('d-m', $date)->startOfDay();
                                            $searchDate = $currentDate->copy()->subDay(); // Commencer à chercher le jour précédent
                                            $limitDays = 7; // Limiter la recherche à 7 jours précédents
                                            $found = false;
                                    
                                            // Chercher la dernière entrée de prix dans les jours précédents
                                            for ($i = 0; $i < $limitDays; $i++) {
                                                $prevDateFormatted = $searchDate->format('d-m');
                                                if (isset($historiquePrix['structuredData'][$concurrent][$prevDateFormatted])) {
                                                    $prevPrice = $historiquePrix['structuredData'][$concurrent][$prevDateFormatted];
                                                    $found = true;
                                                    break;
                                                }
                                                $searchDate->subDay(); // Remonter d'un jour
                                            }
                                    
                                            // Calculer la variation
                                            if ($found && $price !== '-') {
                                                $variation = $price - $prevPrice;
                                                $arrow = $variation > 0 ? '↑' : ($variation < 0 ? '↓' : '=');
                                                $color = $variation > 0 ? 'text-green-500' : ($variation < 0 ? 'text-red-500' : 'text-gray-500');
                                            } else {
                                                $variation = 'N/A'; // Pas de variation si aucun prix précédent trouvé ou prix actuel inconnu
                                                $arrow = '—'; // Symbole pour indiquer l'absence de données
                                                $color = 'text-gray-500'; // Couleur neutre
                                            }
                                        @endphp
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $color }}">{{ $data[$date] ?? '-' }} {{ $arrow }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Aucune donnée disponible pour ce produit.</p>
            @endif
        </div>
    </div>
    <div class="flex flex-wrap space-x-2 justify-center">
        @if(!empty($produits))
            @foreach ($produits as $produit)
                <a href="{{ route('dashboard.changeProduit', $produit->id) }}" class="m-2 px-4 py-2 rounded-full cursor-pointer {{ $produit->id == $selectedProduit->id ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'}}">
                    {{ $produit->designation }}
                </a>
            @endforeach
        @else
            <p>Pas de produits disponible pour la catégorie : {{ $selectedCategorie->nom }}</p>
        @endif
    </div>
</x-app-layout>