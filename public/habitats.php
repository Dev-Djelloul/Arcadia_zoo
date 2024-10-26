<?php
require_once('../back-end-php/config.php');

// Récupération des habitats
$sql_habitats = "SELECT id, NomHabitat, DescriptionHabitat, ImageHabitat FROM Habitat";
$result_habitats = $conn->query($sql_habitats);

// Récupération des commentaires sur les habitats
$sql_comments = "SELECT NomHabitat, Commentaires FROM CommentairesHabitats";
$result_comments = $conn->query($sql_comments);
$comments = [];
while ($row = $result_comments->fetch(PDO::FETCH_ASSOC)) {
    $comments[$row['NomHabitat']][] = $row['Commentaires'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos habitats à Arcadia Zoo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        .habitat {
            text-align: center;
        }
        .habitat h3 {
            margin-top: 10px;
        }
        .habitat h3:hover {
            color: #bc8909;
        }
        .habitat p {
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-1">
                    <a href="/index.html">
                        <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo">
                    </a>
                </div>
                <div class="col-md-10">
                    <nav>
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a href="/index.html" class="nav-link" style="font-size: 20px">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a href="/public/services.php" class="nav-link" style="font-size: 20px">Nos Services</a>
                            </li>
                            <li class="nav-item">
                                <a href="/public/habitats.php" class="nav-link" style="font-size: 20px">Nos Habitats</a>
                            </li>
                            <li class="nav-item">
                                <a href="/public/contact.html" class="nav-link" style="font-size: 20px">Contact</a>
                            </li>
                            <li class="nav-item" id="loginNavItem">
                                <a id="loginLink" href="/public/connexion.html" class="nav-link" style="font-size: 20px">Connexion</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-1">
                    <a href="/index.html">
                        <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Laissez vos sens vous guider à travers nos merveilleux habitats le temps d'une belle après-midi 🌞</h1>
        <div class="row">
            <?php
            if ($result_habitats !== false && $result_habitats->rowCount() > 0) {
                $count = 0;
                while ($row = $result_habitats->fetch(PDO::FETCH_ASSOC)) {
                    $nomHabitat = htmlspecialchars($row['NomHabitat']);
                    ?>
                    <div class="col-md-6 mb-4">
                        <div class="habitat">
                            <?php
                            if (!empty($row['ImageHabitat'])) {
                                echo '<img src="' . htmlspecialchars($row['ImageHabitat']) . '" alt="' . htmlspecialchars($row['NomHabitat']) . '" class="img-fluid" />';
                            } else {
                                echo '<img src="/assets/images/default-service-image.jpg" alt="' . htmlspecialchars($row['NomHabitat']) . '" class="img-fluid" />'; // Image par défaut si aucune image spécifiée
                            }
                            ?>
                            <h3><?php echo $nomHabitat; ?></h3>
                            <p><?php echo htmlspecialchars($row['DescriptionHabitat']); ?></p>
                            <a href="animal.php?NomHabitat=<?php echo urlencode($row['NomHabitat']); ?>" class="btn btn-primary">👈 Découvrez nos vedettes par ici 👉</a>

                            <!-- Affichage des commentaires -->
                            <?php if (isset($comments[$nomHabitat])): ?>
                                <div class="mt-3">
                                    <h5>Derniers commentaires laissés par le vétérinaire :</h5>
                                    <?php foreach ($comments[$nomHabitat] as $commentaire): ?>
                                        <h7><?php echo htmlspecialchars($commentaire); ?></h7>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php
                    $count++;
                    // Ferme la ligne après chaque deuxième habitat
                    if ($count % 2 == 0) {
                        echo '</div><div class="row">';
                    }
                }
            } else {
                ?>
                <p class="text-center">Actuellement, il n'y a aucun habitat disponible.</p>
                <?php
            }
            ?>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-4">
                        <h6 class="text-center">Comment venir au parc zoologique d'Arcadia ?</h6>
                        <p class="text-center text-white">
                            Arcadia Zoo<br />
                            123 Rue des Animaux<br />
                            Ville des Animaux, 12345<br />
                        </p>
                    </div>
                    <div>
                        <h6 class="text-center">Nous contacter</h6>
                        <p class="text-center text-white">
                            Téléphone: 0123-456-789<br />
                            Email: info.arcadiazoo@gmail.com
                        </p>
                    </div>
                </div>
                <div class="col-md-8 text-center">
                    <div class="mb-4">
                        <h6>Horaires d'ouverture</h6>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <p class="text-white">Lundi à Vendredi</p>
                                <p class="text-white">Samedi et Dimanche</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-white">De 9h à 18h</p>
                                <p class="text-white">De 9h à 20h</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-white">Fermé le mardi et les jours fériés</p>
                            </div>
                        </div>
                        <div>
                            <h6>Suivez-nous</h6>
                            <div class="d-flex justify-content-center">
                                <a href="https://www.facebook.com/" class="social-icon mx-2"><i class="fab fa-facebook"></i> Facebook</a>
                                <a href="https://twitter.com/?lang=fr" class="social-icon mx-2"><i class="fab fa-twitter"></i> Twitter</a>
                                <a href="https://www.instagram.com/" class="social-icon mx-2"><i class="fab fa-instagram-square"></i> Instagram</a>
                                <a href="https://www.linkedin.com/feed/" class="social-icon mx-2"><i class="fab fa-linkedin"></i> Linkedin</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
<?php
$conn = null;
?>
