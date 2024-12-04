<?php
session_start();
require_once('fonctions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CDCraze | Vente de CDs en ligne</title>

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <header>
        <?php genererNavBar(); ?>
    </header>

    <div class="container">

        <div id="titre" class="mt-5 mb-5">
            <h1 class="h1">Nos CDs</h1>
        </div>

        <?php
        $conn = connectionBD();
        mysqli_set_charset($conn, "utf8mb4");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM `cd` ORDER BY auteur";
        $result = $conn->query($sql);
        if (!$result) {
            die("Erreur lors de l'exécution de la requête : " . $conn->error);
        }

        if ($result->num_rows == 0) {
            echo "Pas d'articles disponibles.";
        }
        ?>

        <div class="row">
            <?php foreach ($result as $row) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card text-decoration-none" style="width: 18rem; min-height: 250px; height: 100%; display: flex; flex-direction: column;">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#fenetreModale-<?= $row['id'] ?>">
                            <img src="<?= 'vignettes/' . $row['image_pochette']; ?>" alt="<?= "Image de " . htmlspecialchars($row["titre"]) ?>" class="card-img-top p-2 rounded-top">
                        </a>
                        <div class="card-body d-flex flex-column justify-content-between" style="flex-grow: 1;">
                            <h5 class="card-title"><?= htmlspecialchars($row['titre']) ?></h5>
                            <div class="d-flex justify-content-between ">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#fenetreModale-<?= $row['id'] ?>">Détails</button>
                                <form method="post" action="index.php" class="d-md-inline-flex">
                                    <?php if ($row['quantite'] == 0) { ?>
                                        <button type="button" class="btn btn-danger" disabled>Indisponible</button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-primary" name="article_id" value="<?= $row['id'] ?>">Ajouter au panier</button>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?= 'Prix : ' . htmlspecialchars($row["prix"]) . ' €' ?>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="fenetreModale-<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header" style="background-color: #007bff; color: white;">
                                <h1 class="modal-title fs-5" id="exampleModalLabel"><?= htmlspecialchars($row['titre']) ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex">
                                <div class="text-center me-3">
                                    <img src="<?= "images/" . htmlspecialchars($row['image_pochette']) ?>" alt="<?= "Image de " . htmlspecialchars($row["titre"]) ?>" class="img-fluid mb-3" style="max-height: 300px;">
                                </div>
                                <div>
                                    <p><strong>Auteur(s) :</strong> <?= htmlspecialchars($row['auteur']) ?></p>
                                    <p><strong>Genre :</strong> <?= htmlspecialchars($row['genre']) ?></p>
                                    <p class="mt-3"><strong>Prix :</strong> <?= htmlspecialchars($row['prix']) ?> €</p>
                                    <p><strong>Quantité :</strong> <?= htmlspecialchars($row['quantite']) ?></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="index.php">
                                    <button type="submit" class="btn btn-primary" name="article_id" value="<?= $row['id'] ?>">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <?php
            $conn->close();
            ?>
        </div>
    </div>

    <?php

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    $article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : 0;

    if ($article_id > 0) {
        $article_index = trouverIndexDesArticles($_SESSION['panier'], $article_id);

        if ($article_index !== false) {
            $_SESSION['panier'][$article_index][1] += 1;
        } else {
            $_SESSION['panier'][] = [$article_id, 1];
        }
    }
    ?>

    <?php genererBasDePage(); ?>

</body>

</html>