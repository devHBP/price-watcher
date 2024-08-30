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