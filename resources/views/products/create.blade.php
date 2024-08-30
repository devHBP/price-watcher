<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter un Produit') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Message de succès -->
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Formulaire -->
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="designation">
                                Désignation
                            </label>
                            <input id="designation" type="text" name="designation" value="{{ old('designation') }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                            @error('designation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="ean">
                                EAN
                            </label>
                            <input id="ean" type="text" name="ean" value="{{ old('ean') }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                            @error('ean')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" for="pvp">
                                PVP
                            </label>
                            <input id="pvp" type="text" name="pvp" value="{{ old('pvp') }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                            @error('pvp')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto mt-3.5">
                <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Désignation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">EAN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">PVP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Edit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Suppr.</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($produits as $produit)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $produit->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $produit->designation }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $produit->ean }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $produit->pvp }}€</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.edit', $produit->id) }}">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Edit_Pencil_01"> <path id="Vector" d="M12 8.00012L4 16.0001V20.0001L8 20.0001L16 12.0001M12 8.00012L14.8686 5.13146L14.8704 5.12976C15.2652 4.73488 15.463 4.53709 15.691 4.46301C15.8919 4.39775 16.1082 4.39775 16.3091 4.46301C16.5369 4.53704 16.7345 4.7346 17.1288 5.12892L18.8686 6.86872C19.2646 7.26474 19.4627 7.46284 19.5369 7.69117C19.6022 7.89201 19.6021 8.10835 19.5369 8.3092C19.4628 8.53736 19.265 8.73516 18.8695 9.13061L18.8686 9.13146L16 12.0001M12 8.00012L16 12.0001" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('products.delete', $produit->id)}}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12.0004 9.5L17.0004 14.5M17.0004 9.5L12.0004 14.5M4.50823 13.9546L7.43966 17.7546C7.79218 18.2115 7.96843 18.44 8.18975 18.6047C8.38579 18.7505 8.6069 18.8592 8.84212 18.9253C9.10766 19 9.39623 19 9.97336 19H17.8004C18.9205 19 19.4806 19 19.9084 18.782C20.2847 18.5903 20.5907 18.2843 20.7824 17.908C21.0004 17.4802 21.0004 16.9201 21.0004 15.8V8.2C21.0004 7.0799 21.0004 6.51984 20.7824 6.09202C20.5907 5.71569 20.2847 5.40973 19.9084 5.21799C19.4806 5 18.9205 5 17.8004 5H9.97336C9.39623 5 9.10766 5 8.84212 5.07467C8.6069 5.14081 8.38579 5.2495 8.18975 5.39534C7.96843 5.55998 7.79218 5.78846 7.43966 6.24543L4.50823 10.0454C3.96863 10.7449 3.69883 11.0947 3.59505 11.4804C3.50347 11.8207 3.50347 12.1793 3.59505 12.5196C3.69883 12.9053 3.96863 13.2551 4.50823 13.9546Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>