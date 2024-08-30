document.getElementById('date-select').addEventListener('change', function() {
    let selectedDate = this.value;  // Récupère la date sélectionnée
    if (selectedDate) {
        let formattedDate = selectedDate;  // Le format attendu est YYYY-MM-DD
        let fileName = `json/results_${formattedDate}.json`;

        // Tenter de charger le fichier JSON correspondant
        fetch(fileName)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Fichier JSON introuvable pour cette date");
                }
                return response.json();
            })
            .then(data => {
                displayData(data);  // Appel de la fonction d'affichage
            })
            .catch(error => {
                document.getElementById('product-list').innerHTML = `<p>${error.message}</p>`;
            });
    }
});

function displayData(data) {
    let productList = document.getElementById('product-list');
    productList.innerHTML = "";  // Réinitialiser l'affichage

    Object.keys(data).forEach(site => {
        let siteDiv = document.createElement('div');
        siteDiv.classList.add('site');
        siteDiv.innerHTML = `<h2>${site}</h2>`;

        data[site].forEach(product => {
            let productDiv = document.createElement('div');
            productDiv.classList.add('product');
            productDiv.innerHTML = `
                <strong>${product.product}</strong><br>
                <span class="competitor-price">Prix concurrent : ${product.price}</span><br>
                <span class="our-price">Notre prix : ${product['start-distrib-price']}</span>
            `;
            siteDiv.appendChild(productDiv);
        });

        productList.appendChild(siteDiv);
    });
}