const syncLink = {

    link: "http://127.0.0.1:8000/run-check-and-update-historique-prix",
    message : null,

    init: () => {
       document.getElementById("sync-prix").addEventListener("click", syncLink.handleClick);
       const message = document.querySelector("p.message-sync");
       syncLink.message = message;
    },

    handleClick: async(evt) => {
        evt.preventDefault();
        // on retire les précédente erreurs
        syncLink.message.classList.remove('text-red-500', 'text-green-500');
        syncLink.textContent = '';

        try{
            const response = await fetch(syncLink.link);
            if(!response.ok){
                syncLink.message.classList.add('text-red-500');
                syncLink.message.textContent = "Une erreur est survenue";
                throw new Error("Une erreur est survenue");
            }
            const data = await response.json();
            syncLink.message.classList.add('text-green-500');
            syncLink.message.textContent = `${data.message}`;
        }
        catch (error){
            syncLink.message.classList.add('text-red-500');
            syncLink.message.textContent = `${error}`;
            throw new Error("Erreur le script à planté");
        }
    },
}
export default syncLink;