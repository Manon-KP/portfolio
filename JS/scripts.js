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

window.addEventListener('load', function() {
    document.getElementById('typed-text').classList.add('start-typing');
});

// Fonction de validation et d'envoi du formulaire
document.querySelector("#contactForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Empêche la soumission du formulaire

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const message = document.getElementById("message").value;

    // Vérification si les champs sont vides
    if (name === "" || email === "" || message === "") {
        alert("Tous les champs doivent être remplis.");
    } else {
        // Ici on simule l'envoi de l'email
        console.log("Simulation d'envoi : ", { name, email, message });

        // Affiche un pop-up de succès
        alert("Merci pour votre message ! Je vous répondrai dans les plus brefs délais.");

        // Réinitialise le formulaire (optionnel)
        document.querySelector("#contactForm").reset();
    }
});

/*
$(document).ready(function() {
    $('#contactForm').on('submit', function(event) {
        event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        // Récupérer les données du formulaire
        var formData = $(this).serialize();

        // Envoyer les données via AJAX à contact.php
        $.ajax({
            url: 'contact.php', // Le fichier PHP qui va traiter le formulaire
            type: 'POST', // Méthode d'envoi
            data: formData, // Données à envoyer
            success: function(response) {
                // Vérifier si la réponse est un message de succès
                if (response.indexOf('Merci pour votre message') !== -1) {
                    // Afficher le modal de succès
                    $('#confirmationModal').modal('show');
                    $('#contactForm')[0].reset(); // Réinitialiser le formulaire
                } else {
                    // Afficher un message d'erreur si la soumission échoue
                    alert(response); // Afficher la réponse d'erreur du PHP
                }
            },
            error: function() {
                alert('Une erreur est survenue. Veuillez réessayer.');
            }
        });
    });
});
*/
