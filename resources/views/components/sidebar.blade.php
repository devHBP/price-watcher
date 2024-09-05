<!-- resources/views/components/sidebar.blade.php -->
<div class="w-full md:w-1/4 bg-gray-100 p-4">
    <h2 class="text-lg font-bold mb-4">Catégories</h2>
    <ul>
        @foreach($categories as $categorie)
            <li class="mb-2">
                <a href="{{ route('dashboard.index', [ 'categorieId' => $categorie->id ])}}" class="category-link text-blue-500 hover:text-blue-700" data-category-id="{{ $categorie->id }}">
                    {{ $categorie->nom }}
                </a>
            </li>
        @endforeach
    </ul>
</div>