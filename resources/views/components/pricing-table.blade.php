
<div class="w-full md:w-3/4 p-4">
    <h2 id="product-title" class="text-xl font-semibold mb-4">Nom du produit</h2>

    <!-- Tableau dynamique -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Concurrent / Date</th>
                    <th class="py-2 px-4 border-b" id="date1">Date 1</th>
                    <th class="py-2 px-4 border-b" id="date2">Date 2</th>
                    <!-- Autres dates dynamiques -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2 px-4 border-b">Concurrent 1</td>
                    <td class="py-2 px-4 border-b" id="prix-concurrent1-date1">N/A</td>
                    <td class="py-2 px-4 border-b" id="prix-concurrent1-date2">N/A</td>
                </tr>
                <!-- Autres concurrents dynamiques -->
            </tbody>
        </table>
    </div>

    <!-- Liste des produits de la catégorie sélectionnée -->
    <h3 class="text-lg font-semibold mt-6 mb-4">Produits de la catégorie</h3>
    <ul id="product-list" class="list-disc pl-5">
        <!-- Les produits de la catégorie sélectionnée seront affichés ici -->
    </ul>
</div>