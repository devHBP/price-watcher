<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le produit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('produits-concurrents.update', $produitConcurrent->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <!-- Liste Déroulante Produits -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="produit_id">
                                Sélectionnez un produit
                            </label>
                            <select id="produit_id" name="produit_id" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Choisir un produit</option>
                                @foreach ($produits as $produit)
                                    <option value="{{ $produit->id }}" {{ old('produit_id', $produitConcurrent->produit->id == $produit->id ? "selected" : "" )}}>{{ $produit->designation }}</option>
                                @endforeach
                            </select>
                            @error('produit_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                            <!-- Liste Déroulante Concurrents -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="concurrent_id">
                                Sélectionnez un Concurrent
                            </label>
                            <select id="concurrent_id" name="concurrent_id" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Choisir un concurrent</option>
                                @foreach ($concurrents as $concurrent)
                                    <option value="{{ $concurrent->id }}" {{ old('concurrent_id', $produitConcurrent->concurrent->id == $concurrent->id ? "selected" : "") }}>{{ $concurrent->nom }}</option>
                                @endforeach
                            </select>
                            @error('concurrent_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Liste Déroulante Catégorie -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="categorie_id">
                                Sélectionnez un Catégorie
                            </label>
                            <select id="categorie_id" name="categorie_id" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Choisir un catégorie</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('categorie_id', $produitConcurrent->categorie->id) == $categorie->id ? "selected" : "" }}>{{ $categorie->nom }}</option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Liste Déroulante url complementaire -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="categorie_url_concurrent_id">
                                Sélectionnez un Categorie chez le concurrent (url complémentaire)
                            </label>
                            <select id="categorie_url_concurrent_id" name="categorie_url_concurrent_id" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Choisir un catégorie</option>
                                @foreach ($categoriesUrlConcurrents as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('categorie-url-concurrent_id', $produitConcurrent->categorieUrlConcurrent->id) == $categorie->id ? "selected" : "" }}>{{ $categorie->nom }}</option>
                                @endforeach
                            </select>
                            @error('categorie_url_concurrent_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="url_produit">
                                Url Produit
                            </label>
                            <input id="url_produit" type="text" name="url_produit" value="{{ old('url_produit', $produitConcurrent->url_produit) }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                            @error('url_produit')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="css_pick_designation">
                                Css pour atteindre le nom du produit
                            </label>
                            <input id="css_pick_designation" type="text" name="css_pick_designation" value="{{ old('css_pick_designation', $produitConcurrent->css_pick_designation ) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                            @error('css_pick_designation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="css_pick_prix">
                                Css pour atteindre le prix du produit
                            </label>
                            <input id="css_pick_prix" type="text" name="css_pick_prix" value="{{ old('css_pick_prix', $produitConcurrent->css_pick_prix )}}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                            @error('css_pick_prix')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Bouton de soumission -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>