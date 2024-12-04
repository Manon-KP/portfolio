<?php

function connectionBD()
{
    $conn = mysqli_connect(
        "lakartxela.iutbayonne.univ-pau.fr",
        "mkpol_bd",
        "mkpol_bd",
        "mkpol_bd"
    ) or die("Connection failed: " . mysqli_connect_error());

    return $conn;
}


function genererNavBar()
{
    echo '
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">CDCraze</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="panier.php">Panier</a>
                        </li>';
    if (isset($_SESSION['login']) && isset($_SESSION['pwd'])) {
        echo '
                        <li class="nav-item">
                            <a class="nav-link" href="tableauDeBord.php">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="btn btn-primary ms-3" tabindex="-1" role="button" aria-disabled="true">Se déconnecter</a>
                        </li>';
    } else {
        echo '
                        <li class="nav-item">
                            <a href="loginPage.php" class="btn btn-primary ms-3" tabindex="-1" role="button" aria-disabled="true">Se connecter</a>
                        </li>';
    }

    echo '
                    </ul>
                </div>
            </div>
        </nav>
        ';
}



function genererBasDePage()
{
    echo '<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>CDCraze</h5>
                <p>Le site de vente en ligne de cds.</p>
            </div>
    </div>
    </footer>
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc5KAIl0S1EICeIm8g7G1p6hsUdeK0N6B/Xm99LHE" crossorigin="anonymous"></script>
    </footer>';
}

function trouverIndexDesArticles($panier, $article_id)
{
    foreach ($panier as $index => $item) {
        if ($item[0] == $article_id) {
            return $index;
        }
    }
    return false;
}



function creerVignette($image_path, $vignette_path, $largeur_vignette = 200)
{
    list($largeur_originale, $hauteur_originale, $type) = getimagesize($image_path);

    $rapport = $largeur_originale / $hauteur_originale;
    $hauteur_vignette = $largeur_vignette / $rapport;

    switch ($type) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($image_path);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($image_path);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($image_path);
            break;
        default:
            return false;
    }

    $vignette = imagecreatetruecolor($largeur_vignette, $hauteur_vignette);
    imagecopyresampled($vignette, $image, 0, 0, 0, 0, $largeur_vignette, $hauteur_vignette, $largeur_originale, $hauteur_originale);

    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($vignette, $vignette_path);
            break;
        case IMAGETYPE_PNG:
            imagepng($vignette, $vignette_path);
            break;
        case IMAGETYPE_GIF:
            imagegif($vignette, $vignette_path);
            break;
    }


    imagedestroy($image);
    imagedestroy($vignette);
}

function supprimerImages($image_pochette)
{
    $image_path = 'images/' . $image_pochette;
    $vignette_path = 'vignettes/' . $image_pochette;

    if (file_exists($image_path)) {
        unlink($image_path); 
    }

    if (file_exists($vignette_path)) {
        unlink($vignette_path); 
    }
}

function createInsertForm()
{
    echo '
    <!-- Modale pour insérer un CD -->
<div class="modal fade" id="insertCdModal" tabindex="-1" aria-labelledby="insertCdModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertCdModalLabel">Ajouter un CD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titre">Titre :</label>
                        <input type="text" class="form-control" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="auteur">Auteur :</label>
                        <input type="text" class="form-control" name="auteur" required>
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre :</label>
                        <input type="text" class="form-control" name="genre" required>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="number" class="form-control" name="prix" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="quantite">Quantité :</label>
                        <input type="number" class="form-control" name="quantite" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image de pochette :</label>
                        <input type="file" class="form-control-file" name="image" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="inserer_cd" class="btn btn-primary">Ajouter CD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';
}


function majStocks()
{
    if (empty($_SESSION['panier'])) {
        throw new Exception("Le panier est vide.");
    }
    $conn = connectionBD();
    mysqli_set_charset($conn, "utf8mb4");
    if ($conn->connect_error) {
        throw new Exception("Erreur de connexion à la base de données : " . $conn->connect_error);
    }
    try {
        $conn->begin_transaction();
        foreach ($_SESSION['panier'] as $article) {
            $articleId = isset($article[0]) ? (int)$article[0] : 0;
            $quantite = isset($article[1]) ? (int)$article[1] : 0;
            if ($articleId > 0 && $quantite > 0) {
                $sql = "UPDATE `cd` SET quantite = GREATEST(0, quantite - ?) WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $quantite, $articleId);
                if (!$stmt->execute()) {
                    throw new Exception("Erreur lors de la mise à jour du stock pour l'article ID " . $articleId);
                }
                $stmt->close();
            } else {
                throw new Exception("Le format du panier est invalide pour l'article avec ID " . htmlspecialchars($articleId));
            }
        }
        $conn->commit();
        unset($_SESSION['panier']);
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    } finally {
        $conn->close();
    }
}
