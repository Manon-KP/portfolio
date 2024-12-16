<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validation simple
    if (empty($name) || empty($email) || empty($message)) {
        // Alerte si un champ est vide
        echo "<script>
                alert('Tous les champs doivent être remplis.');
                window.location.href = 'index.html';  // Redirige vers la page d'accueil après l'alerte
              </script>";
    } else {
        // Ici on simule le succès sans envoyer de mail
        echo "<script>
                alert('Merci pour votre message ! Je vous répondrai dans les plus brefs délais.');
                window.location.href = 'index.html';  // Redirige vers la page d'accueil après l'alerte
              </script>";
    }
}

/*
// Sinon il faut faire : 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validation simple (vous pouvez ajouter d'autres vérifications ici)
    if (empty($name) || empty($email) || empty($message)) {
        echo "Tous les champs doivent être remplis.";
        exit;
    }

    // Paramètres de l'email
    $to = "xidopoy807@owube.com"; // Votre adresse e-mail
    $subject = "Nouveau message de $name depuis votre site portfolio";
    $body = "Nom: $name\nEmail: $email\nMessage:\n$message";
    $headers = "From: $email";

    // Envoyer l'email
    if (mail($to, $subject, $body, $headers)) {
        echo "Merci pour votre message ! Je vous répondrai dans les plus brefs délais.";
    } else {
        echo "Une erreur est survenue, veuillez réessayer.";
    }
}

*/