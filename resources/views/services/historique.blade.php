<x-app-layout>
    <x-slot name="header">
        <h2 clas="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{__('Historique des prix')}}
        </h2>
    </x-slot>
    <div class="py-12 bg-slate-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 sm:py-4 lg:py-8">
            <ul class="flex-row">
                @foreach ($historiques as $key => $historique)
                    <li class="flex justify-between">
                        <span>{{ $key }} / {{ $historique->id }}</span>
                        <span>{{ $historique->produitConcurrent->designation_concurrent }}</span>
                        <span>{{ $historique->produitConcurrent->created_at }}</span>
                        <span>{{ $historique->updated_at}}</span> 
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>