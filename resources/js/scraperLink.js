const scraperLink = {

    durationTime: null,
    buttonLink : null,
    link: "http://127.0.0.1:8000/run-scraper",

    init: () => {
        // Récupération du temps approximatif du script
        scraperLink.durationTime = document.querySelector('span.duration-time').innerText;
        // Bind du bouton "lancer le script"
        const buttonScript = document.getElementById('run-scraper-link');
        // on sauvegarde le bouton dans le propriété
        scraperLink.buttonLink = buttonScript;
        buttonScript.addEventListener('click', scraperLink.handleClick);
    },

    handleClick: (event) => {
        event.preventDefault();
        scraperLink.buttonLink.disabled = true;
        scraperLink.buttonLink.textContent = "Scraping en cours";

        const progressBar = document.querySelector('div.progress-bar');
        const progressContainer = document.querySelector('div.progress-container');

        progressContainer.style.display = 'block';

        const response = scraperLink.fetchData();

    },

    fetchData: async() => {
        try{
            const response = await fetch(scraperLink.link);

            if(!response.ok){
                throw new Error('Une erreur est survenue');
            }

            const data = await response.json();
            let progress = 0;
            const increment = 100 / scraperLink.durationTime;

            const progressBar = document.querySelector('div.progress-bar');
            const interval = setInterval(()=>{
                progress += increment;
                progressBar.style.width;
                if(progress >= 100){
                    clearInterval(interval);
                }
            }, 1000);
        }
        catch{
            throw new Error("Le script s'est arrété de fonctionné");
        }
        finally{
            scraperLink.buttonLink.disabled = false;
            scraperLink.buttonLink.textContent = "Lancer le Scraper";
        }
    },
}

export default scraperLink;