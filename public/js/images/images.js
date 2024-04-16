
suppressionImage = () => {
    // Gestion des boutons "Supprimer"
    let links = document.querySelectorAll("[data-delete]")
    // On boucle sur links
    for(link of links){
        // On écoute le clic
        link.addEventListener("click", function(e){
            // On vérifie le nombre d'image
            let pictureNumber = 1;
            if(document.querySelectorAll(".picture").length > pictureNumber){
                // On empêche la navigation
                e.preventDefault()
                // On demande confirmation
                if(confirm("Voulez-vous supprimer cette image ?")){
                    // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
                    fetch(this.getAttribute("href"), {
                        method: "DELETE",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({"_token": this.dataset.token})
                    }).then(
                        // On récupère la réponse en JSON
                        response => response.json()
                    ).then(data => {
                        if(data.success)
                            this.parentElement.remove()
                        else{
                            alert(data.error)
                        }
                    }).catch(e => alert(e))
                }
            }else{
                e.preventDefault()
                // On indique qu'une recette ne peux pas posséder moin de 1 image
                if(confirm("Impossible de supprimer cette image. Une annonce doit contenir au moin " +  pictureNumber + " image")){
                }
            }
        })
    } 
}