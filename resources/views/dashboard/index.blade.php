<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau Comparatif') }}
        </h2>
    </x-slot>

    <!-- Conteneur principal avec Flexbox -->
    <div class="flex flex-col md:flex-row p-4 space-x-4">
        
        <!-- Panneau latéral pour les catégories (1/4 de l'espace) -->
        <div id="categories-container" class="w-full md:w-1/4 bg-gray-100 p-4 rounded-lg">
            <h2 class="text-lg font-bold mb-4">Catégories</h2>
            <ul id="categories-list"></ul>
        </div>

        <!-- Contenu principal (3/4 de l'espace) -->
        <div class="w-full md:w-3/4 bg-white p-4 rounded-lg shadow-md">
                        <!-- Tableau pour les données historiques -->
                        <div id="historical-data" class="overflow-x-auto">
                            <table class="" id="historical-table" class="min-w-full bg-white border border-gray-300 hidden">
                                <thead>
                                    <tr id="table-header"></tr>
                                </thead>
                                <tbody id="table-body"></tbody>
                            </table>
                        </div>
        </div>
    </div>
    <!-- Section pour les produits -->
    <h2 class="text-lg font-bold mb-4 ml-4">Produits</h2>
    <div id="products-container" class="flex flex-wrap space-x-2 mb-4"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables globales
            let selectedCategory = null;
            let selectedProduct = null;
            let historicalData = { dates: [], structuredData: {} };

            // Fetch Categories
            function fetchCategories() {
                fetch('/dashboard/categories')
                    .then(response => response.json())
                    .then(data => {
                        const categoriesList = document.getElementById('categories-list');
                        categoriesList.innerHTML = '';

                        data.forEach(categorie => {
                            const li = document.createElement('li');
                            const button = document.createElement('button');
                            button.textContent = categorie.nom;
                            button.className = 'block w-full text-left p-2 rounded';
                            button.onclick = () => fetchProducts(categorie.id);
                            li.appendChild(button);
                            categoriesList.appendChild(li);
                        });

                        if (data.length) {
                            selectedCategory = data[0].id;
                            fetchProducts(selectedCategory);
                        }
                    });
            }

            // Fetch Products
            function fetchProducts(categorieId) {
                fetch(`/dashboard/produits/${categorieId}`)
                    .then(response => response.json())
                    .then(data => {
                        const productsContainer = document.getElementById('products-container');
                        productsContainer.innerHTML = '';

                        data.forEach(produit => {
                            const button = document.createElement('button');
                            button.textContent = produit.designation;
                            button.className = 'm-2 px-4 py-2 rounded-full cursor-pointer';
                            button.onclick = () => {
                                selectedProduct = produit.id;
                                fetchHistoricalData();
                            };
                            productsContainer.appendChild(button);
                        });

                        if (data.length) {
                            selectedProduct = data[0].id;
                            fetchHistoricalData();
                        }
                    });
            }

            // Fetch Historical Data
            function fetchHistoricalData() {
                fetch(`/dashboard/historique-prix/${selectedProduct}`)
                    .then(response => response.json())
                    .then(data => {
                        historicalData = data;
                        renderTable();
                    });
            }

            // Render Table
            function renderTable() {
                const tableHeader = document.getElementById('table-header');
                const tableBody = document.getElementById('table-body');
                const historicalTable = document.getElementById('historical-table');

                tableHeader.innerHTML = '';
                tableBody.innerHTML = '';

                // Create table headers
                const headerRow = document.createElement('tr');
                const firstHeader = document.createElement('th');
                firstHeader.textContent = 'Concurrents';
                headerRow.appendChild(firstHeader);
                historicalData.dates.forEach(date => {
                    const th = document.createElement('th');
                    th.textContent = date;
                    headerRow.appendChild(th);
                });
                tableHeader.appendChild(headerRow);

                // Create table rows for each concurrent
                Object.keys(historicalData.structuredData).forEach(concurrent => {
                    const row = document.createElement('tr');
                    const firstCell = document.createElement('td');
                    firstCell.textContent = concurrent;
                    row.appendChild(firstCell);

                    historicalData.dates.forEach(date => {
                        const cell = document.createElement('td');
                        cell.textContent = historicalData.structuredData[concurrent][date] || '-';
                        row.appendChild(cell);
                    });

                    tableBody.appendChild(row);
                });

                historicalTable.classList.remove('hidden');
            }

            // Initialize
            fetchCategories();
        });
    </script>
</x-app-layout>