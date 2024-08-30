<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Modifier l'url complémentaire") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('categories-url-concurrents.update', $url->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <!-- Designation -->
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nom du concurrent</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $url->nom) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('nom')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- URL -->
                        <div class="mb-4">
                            <label for="url_complement" class="block text-sm font-medium text-gray-700 dark:text-gray-200">URL Complémentaire</label>
                            <input type="text" name="url_complement" id="url_complement" value="{{ old('url_complement', $url->url_complement) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            @error('url_complement')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Choix du concurrent -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="concurrent_id">
                                Sélectionnez un Concurrent
                            </label>
                            <select id="concurrent_id" name="concurrent_id" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach ($concurrents as $concurrent)
                                    <option value="{{ $concurrent->id }}" {{ old('concurrent_id', $url->concurrent_id) == $concurrent->id ? 'selected' : ''}}>
                                        {{ $concurrent->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('concurrent_id')
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