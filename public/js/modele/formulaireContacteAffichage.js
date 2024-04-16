
formulaireContacteAffichage = () => {
    // On crée une variable liée a l'élément .formulaire-btn
    let btn = document.querySelector(".formulaire-btn");
    // On crée une variable liée à l'élément .formulaire-contacte__content
    let formulaireContacte = document.querySelector(".formulaire-contacte");
    // On crée une variable liée à l'élément formulaire-avis__close-icon
    let formulaireContacteClose = document.querySelector(".formulaire-contacte__close-icon");
    // On crée une variable liée à l'élément header
    let header = document.querySelector("header");
    // On crée une variable liée à l'élément main
    let main = document.querySelector("main");
    // On crée une variable liée à l'élément footer
    let footer = document.querySelector("footer");
    // On crée une variable liée à l'élément body
    let body = document.querySelector("body");
    // On détecte le clique sur l'icon nav
    btn.addEventListener('click', () => {
        // On met le display de l'élément nav en flex pour l'afficher
        formulaireContacte.style.display = "flex";
        // On ajoute pour les élément header main nav la class avis-floux qui créra l'effet de floux
        header.className = 'floux';
        main.className = 'floux';
        footer.className = 'floux';
        // On bloque le scoll lors de l'activation du formulaire
        body.style.overflow = 'hidden';
    })
    // On détecte le clique sur l'icon close
    formulaireContacteClose.addEventListener('click', () => {
        // On met le display de l'élément nav en none pour le cacher
        formulaireContacte.style.display = "none";
        // On retire pour les élément header main nav la class avis-floux qui créra l'effet de floux
        header.className = '';
        main.className = '';
        footer.className = '';
        // On réactive le scroll
        body.style.overflow = 'auto';
    })
}
