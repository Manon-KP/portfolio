// Attendre que le DOM soit complètement chargé
document.addEventListener('DOMContentLoaded', function () {
    // Sélectionner tous les liens de la barre de navigation
    const navLinks = document.querySelectorAll('nav .nav-link');

    // Ajouter un événement de clic à chaque lien
    navLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            // Empêcher le comportement par défaut du lien
            event.preventDefault();

            // Récupérer l'ID de la section cible (ex. #hero, #a-propos, etc.)
            const targetId = link.getAttribute('href');
            const targetSection = document.querySelector(targetId);

            // Faire défiler jusqu'à la section cible avec un défilement doux
            targetSection.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});


