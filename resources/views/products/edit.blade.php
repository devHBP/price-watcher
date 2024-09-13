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
                    <form action="{{ route('products.update', $produit->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Liste Déroulante Catégorie -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="categorie_id">
                                Sélectionnez un Catégorie
                            </label>
                            <select id="categorie_id" name="categorie_id" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Choisir un catégorie</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('categorie_id', $produit->categorie->id) == $categorie->id ? "selected" : "" }}>{{ $categorie->nom }}</option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Designation -->
                        <div class="mb-4">
                            <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Désignation</label>
                            <input type="text" name="designation" id="designation" value="{{ old('designation', $produit->designation) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('designation')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- EAN -->
                        <div class="mb-4">
                            <label for="ean" class="block text-sm font-medium text-gray-700 dark:text-gray-200">EAN</label>
                            <input type="text" name="ean" id="ean" value="{{ old('ean', $produit->ean) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('ean')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- PVP -->
                        <div class="mb-4">
                            <label for="pvp" class="block text-sm font-medium text-gray-700 dark:text-gray-200">PVP (€)</label>
                            <input type="number" name="pvp" id="pvp" value="{{ old('pvp', $produit->pvp) }}" step="0.01" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('pvp')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Minimal PVP -->
                        <div class="mb-4">
                            <label for="m_pvp" class="block text-sm font-medium text-gray-700 dark:text-gray-200">PVP Minimal(€)</label>
                            <input type="number" name="m_pvp" id="m_pvp" value="{{ old('m_pvp', $produit->m_pvp) }}" step="0.01" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('m_pvp')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
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