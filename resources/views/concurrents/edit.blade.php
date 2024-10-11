<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier la Catégorie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('concurrents.update', $concurrent->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <!-- Designation -->
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nom du concurrent</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $concurrent->nom) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('nom')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- URL -->
                        <div class="mb-4">
                            <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">URL du concurrent</label>
                            <input type="text" name="url" id="url" value="{{ old('url', $concurrent->url) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('url')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="est_francais" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Type de Concurrent</label>
                            <select name="est_francais" id="est_francais" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                                <option class="text-sm" value="1" {{ old('est_francais', $concurrent->est_francais ?? '') == '1' ? 'selected' : '' }}>Français</option>
                                <option class="text-sm" value="0" {{ old('est_francais', $concurrent->est_francais ?? '') == '0' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="css_pick_designation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Methode de séléction du titre</label>
                            <input type="text" name="css_pick_designation" id="css_pick_designation" value="{{ old('css_pick_designation', $concurrent->css_pick_designation) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('css_pick_designation')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="css_pick_prix" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Methode de séléction de prix</label>
                            <input type="text" name="css_pick_prix" id="css_pick_prix" value="{{ old('css_pick_prix', $concurrent->css_pick_prix) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('css_pick_prix')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="css_pick_badge_rupture" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Methode de séléction du Badge de Rupture</label>
                            <input type="text" name="css_pick_badge_rupture" id="css_pick_badge_rupture" value="{{ old('css_pick_badge_rupture', $concurrent->css_pick_badge_rupture) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('css_pick_badge_rupture')
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