<?php
require_once('../back-end-php/config.php');

if (isset($_GET['NomHabitat'])) {
    $NomHabitat = urldecode($_GET['NomHabitat']);

    // Récupére les animaux dans l'habitat spécifié
    $sql_animaux = "SELECT * FROM Animal WHERE NomHabitat = :NomHabitat";
    $stmt_animaux = $conn->prepare($sql_animaux);
    $stmt_animaux->execute(['NomHabitat' => $NomHabitat]);
    $animaux = $stmt_animaux->fetchAll(PDO::FETCH_ASSOC);

    // Prépare un tableau pour les comptes-rendus associés à chaque animal
    $comptes_rendus = [];

    foreach ($animaux as $animal) {
        // Récupére les comptes-rendus pour cet animal
        $sql_comptes_rendus = "
            SELECT * FROM ComptesRendusVeterinaires
            WHERE Prenom = :Prenom
            ORDER BY DatePassage DESC
        ";
        $stmt_comptes_rendus = $conn->prepare($sql_comptes_rendus);
        $stmt_comptes_rendus->execute(['Prenom' => $animal['Prenom']]);
        $comptes_rendus[$animal['Prenom']] = $stmt_comptes_rendus->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animaux de <?php echo htmlspecialchars($NomHabitat); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        <h1><?php echo htmlspecialchars($NomHabitat); ?></h1>
        <h3 class="text-center mb-4">Venez à la rencontre de nos icônes !</h3>
        <div class="row">
            <?php
            if (!empty($animaux)) {
                foreach ($animaux as $animal) {
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="<?php echo htmlspecialchars($animal['ImageAnimal']); ?>" class="card-img-top" alt="Image de <?php echo htmlspecialchars($animal['Prenom']); ?>">
                            <div class="card-body">
                                <p class="card-text">
                                    <h2>Son prénom c'est <?php echo htmlspecialchars($animal['Prenom']); ?></h2><br>
                                    <h4>Son espèce </h4> <?php echo htmlspecialchars($animal['Race']); ?>
                                </p>
                                <!-- Affichage des comptes-rendus pour cet animal -->
                                <?php if (isset($comptes_rendus[$animal['Prenom']])) : ?>
                                    <h5 class="mt-3">Les comptes-rendus du vétérinaire :</h5>
                                    <div class="list-group">
                                        <?php foreach ($comptes_rendus[$animal['Prenom']] as $cr) : ?>
                                            <div class="list-group-item">
                                                <h8><strong>Date de passage :</strong> <?php echo htmlspecialchars($cr['DatePassage']); ?></h8>
                                                <h6><strong>État de l'animal :</strong> <?php echo htmlspecialchars($cr['EtatAnimal']); ?></h6>
                                                <h7><strong>Nourriture proposée :</strong> <?php echo htmlspecialchars($cr['Nourriture']); ?></p>
                                                <h6><strong>Grammage de la nourriture :</strong> <?php echo htmlspecialchars($cr['Grammage']); ?> g</h6>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <p class="text-center">Aucun compte-rendu disponible pour cet animal.</p>
                                <?php endif; ?>
                                <!-- Bouton pour augmenter les consultations d'animaux par les visiteurs -->
                                <button class="btn btn-primary mt-3 increase-consultation" data-prenom="<?php echo htmlspecialchars($animal['Prenom']); ?>">Si vous aimez cet animal, cliquez ici !</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <p class="text-center">Actuellement, il n'y a aucun animal disponible dans cet habitat.</p>
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
                                <p class="text-white">9h00 - 18h00</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-white">Samedi et Dimanche</p>
                                <p class="text-white">10h00 - 19h00</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6>Suivez-nous</h6>
                        <a href="https://www.facebook.com/ArcadiaZoo" target="_blank" class="text-white">Facebook</a> |
                        <a href="https://www.instagram.com/ArcadiaZoo" target="_blank" class="text-white">Instagram</a> |
                        <a href="https://twitter.com/ArcadiaZoo" target="_blank" class="text-white">Twitter</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fonction pour gérer le clic sur le bouton d'augmentation de consultation
            $('.increase-consultation').click(function() {
                var prenom = $(this).data('prenom'); // Récupére le prénom de l'animal
                $.ajax({
                    url: '/back-end-php/users/visiteur/update_consultation.php',
                    type: 'GET',
                    data: { Prenom: prenom },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Merci pour votre participation 😊');
                        } else {
                            alert('Erreur lors de la mise à jour de la consultation.');
                        }
                    },
                    error: function() {
                        alert('Erreur de requête.');
                    }
                });
            });
        });
    </script>

</body>
</html>
