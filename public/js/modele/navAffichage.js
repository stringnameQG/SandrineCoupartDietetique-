// On attende le chargement complét de la page 

navAffichage = () => {
    // On crée une variable liée a l'élément .nav-icon
    let navIcon = document.querySelector(".nav-icon");
    // On crée une variable liée à l'élément nav
    let nav = document.querySelector(".nav-list");
    // On crée une variable liée a l'élément .nav-icon
    let navIconClose = document.querySelector(".nav-list__close-icon");
    // On détecte le clique sur l'icon nav
    navIcon.addEventListener('click', () => {
        // On met le display de l'élément nav en flex pour l'afficher
        nav.style.display = "flex";
        navIcon.style.display = "none";
    })
    // On détecte le clique sur l'icon close
    navIconClose.addEventListener('click', () => {
        // On met le display de l'élément nav en none pour le cacher
        nav.style.display = "none";
        navIcon.style.display = "flex";
    })
}

function resizeWindowWidth() {  
    // On crée une variable qui récupére la largeur de la fenétre
    let windowWidth = window.outerWidth;
    // On crée une variable liée a l'élément .nav-icon
    let navIcon = document.querySelector(".nav-icon");
    // On crée une variable liée à l'élément nav
    let nav = document.querySelector(".nav-list");
    // Si la largeur de la fenétre est supérieur ou égale à 1000 px
    if(windowWidth >= 1000){
        // On met le display de l'élément nav en flex pour l'afficher
        nav.style.display = "flex";
        navIcon.style.display = "none";
        // Si non
    } else {
        // On met le display de l'élément nav en none pour le cacher
        nav.style.display = "none";
        navIcon.style.display = "flex";
    }
}