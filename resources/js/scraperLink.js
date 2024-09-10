const scraperLink = {

    durationTime: null,
    buttonLink : null,
    progressContainer: null,
    progressBar: null,
    interval: null,
    logPollingInterval: null,
    link: "http://127.0.0.1:8000",

    init: () => {
        // Récupération du temps approximatif du script
        scraperLink.durationTime = document.querySelector('span.duration-time').innerText;
        // Bind du bouton "lancer le script"
        const buttonScript = document.getElementById('run-scraper-link');
        // on sauvegarde le bouton dans le propriété
        scraperLink.buttonLink = buttonScript;
        buttonScript.addEventListener('click', scraperLink.handleClick);

        const progressContainer = document.querySelector("div.progress-container");
        scraperLink.progressContainer = progressContainer;

        const progressBar = document.querySelector("div.progress-bar");
        scraperLink.progressBar = progressBar;
    },

    handleClick: (event) => {
        event.preventDefault();
        scraperLink.buttonLink.disabled = true;
        scraperLink.buttonLink.textContent = "Scraping en cours";

        scraperLink.progressContainer.style.display = 'block';
        scraperLink.startLogPolling();
        scraperLink.fetchData();
    },

    startLogPolling : () => {
        scraperLink.logPollingInterval = setInterval(async () => {
            try{
                const response = await fetch(`${scraperLink.link}/services/logs-scraping`);
                const logData = await response.json();
                scraperLink.updateLogDisplay(logData);
                scraperLink.updateProgressBar(logData);
                if(logData.currentIndex !== 0 && (logData.currentIndex === logData.totalProducts)){
                    clearInterval(scraperLink.logPollingInterval);
                    // retrait de la progress bar
                    scraperLink.progressContainer.style.display = 'none';
                    // réinit de la progression
                    scraperLink.progressBar.style.width = "0%";
                    scraperLink.buttonLink.disabled = false;
                    scraperLink.buttonLink.textContent = "Lancer le Script";
                }
            }
            catch(error){
                console.log("Erreur lors de la récupération: ", error);
                // Assurer d'arrêter le polling des logs en cas d'erreur
                clearInterval(scraperLink.logPollingInterval);

                // Remettre l'état initial de l'interface utilisateur
                scraperLink.progressContainer.style.display = 'none';
                scraperLink.progressBar.style.width = "0%";
                scraperLink.progressBar.textContent = "";

                scraperLink.buttonLink.disabled = false;
                scraperLink.buttonLink.textContent = "Lancer le Script";
            }
        }, 2500);
    },

    updateLogDisplay : (logData) => {
        console.log(logData);
        logData.currentIndex = parseInt(logData.currentIndex);
        logData.totalProducts = parseInt(logData.totalProducts);
        const logContainer = document.querySelector("p.message-scraper");
        logContainer.textContent = `Produit: ${logData.productName}, Prix : ${logData.price}, (${logData.currentIndex}/${logData.totalProducts})`
    },

    updateProgressBar : (logData) =>{
        logData.currentIndex = parseInt(logData.currentIndex);
        logData.totalProducts = parseInt(logData.totalProducts);
        const progressPercentage = ( logData.currentIndex / logData.totalProducts) * 100;
        scraperLink.progressBar.style.width = `${progressPercentage}%`;
        scraperLink.progressBar.textContent = `${Math.floor(progressPercentage)}%`;
    },

    fetchData: async() => {
        try{
            const response = await fetch(`${scraperLink.link}/run-scraper`);

            if(!response.ok){
                throw new Error('Une erreur est survenue');
            }

            const data = await response.json();
        }
        catch(error){
            console.error("Le script s'est arrêté de fonctionner", error);
            alert("Une erreur est survenue lors de l'exécution du script.");
        }
    },
}

export default scraperLink;