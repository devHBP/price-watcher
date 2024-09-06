<x-app-layout>
    <x-slot name="header">
        <h2 clas="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{__('Options spécifiques')}}
        </h2>
    </x-slot>
    <div class="py-12 bg-slate-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 sm:py-4 lg:py-8">
            <div class="flex-col flex-wrap space-x-4 justify-center">
                <p class="mb-4">Forcer le lancement du script de scraping ( prends environ : <span class='duration-time'>{{ $averageDuration }}</span> secondes )</p>
                <a href="" id="run-scraper-link" class="m-2 px-4 py-2 rounded-full cursor-pointer bg-blue-500 text-white">Lancer le Script</a>
                <div class="progress-container" style="display:none;">
                    <div class="progress-bar" style="width:0%; height:30px; background-color:green;"></div>
                </div>
            </div>
            <div class="pt-8">
                <p class="mb-4">Sauvegarder l'historique des prix produit sur la date du jour sans doublons</p>
                <a href="" class="m-2 px-4 py-2 rounded-full cursor-pointer bg-blue-500 text-white">Synchroniser les prix</a>
            </div>
            <div class="pt-8">
                <p class="mb-4">Voir les HistoriquePrixProduit du jour ( vérif/gestion des doublons )</p>
                <a href="{{ route('service.historique') }}" class="m-2 px-4 py-2 rounded-full cursor-pointer bg-blue-500 text-white">Historique des prix</a>
            </div>
        </div>
    </div>
</x-app-layout>