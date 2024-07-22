<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'veterinaire') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';

// Récupération des informations d'alimentation pour chaque animal
$sql_alimentation = "SELECT Prenom, DateAlimentation, HeureAlimentation, Nourriture, Quantite FROM AlimentationAnimaux ORDER BY DateAlimentation DESC, HeureAlimentation DESC";
$stmt_alimentation = $conn->prepare($sql_alimentation);
$stmt_alimentation->execute();
$alimentation = $stmt_alimentation->fetchAll(PDO::FETCH_ASSOC);

// Récupération des animaux pour le formulaire de comptes rendus
$sql_animaux = "SELECT id, Prenom FROM Animal";
$stmt_animaux = $conn->prepare($sql_animaux);
$stmt_animaux->execute();
$animaux = $stmt_animaux->fetchAll(PDO::FETCH_ASSOC);

// Récupération des habitats pour le formulaire de commentaires
$sql_habitats = "SELECT NomHabitat FROM Habitat";
$stmt_habitats = $conn->prepare($sql_habitats);
$stmt_habitats->execute();
$habitats = $stmt_habitats->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_compte_rendu'])) {
        // Traitement du formulaire de comptes rendus vétérinaires
        $idAnimal = $_POST['animal'];
        $etatAnimal = $_POST['etat_animal'];
        $nourriture = $_POST['nourriture'];
        $grammage = $_POST['grammage'];
        $datePassage = $_POST['date_passage'];

        // Récupérer le prénom de l'animal
        $sql_prenom = "SELECT Prenom FROM Animal WHERE id = ?";
        $stmt_prenom = $conn->prepare($sql_prenom);
        $stmt_prenom->execute([$idAnimal]);
        $prenom = $stmt_prenom->fetchColumn();

        $sql_compte_rendu = "INSERT INTO ComptesRendusVeterinaires (Prenom, EtatAnimal, Nourriture, Grammage, DatePassage) VALUES (?, ?, ?, ?, ?)";
        $stmt_compte_rendu = $conn->prepare($sql_compte_rendu);
        $stmt_compte_rendu->execute([$prenom, $etatAnimal, $nourriture, $grammage, $datePassage]);

        $_SESSION['message'] = 'Compte rendu ajouté avec succès !';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['submit_commentaire'])) {
        // Traitement du formulaire de commentaires sur les habitats
        $nomHabitat = $_POST['habitat'];
        $commentaire = $_POST['commentaire'];
        $dateCommentaire = $_POST['date_commentaire'];

        $sql_commentaire = "INSERT INTO CommentairesHabitats (NomHabitat, Commentaires, DateCommentaire) VALUES (?, ?, ?)";
        $stmt_commentaire = $conn->prepare($sql_commentaire);
        $stmt_commentaire->execute([$nomHabitat, $commentaire, $dateCommentaire]);

        $_SESSION['message'] = 'Commentaire ajouté avec succès !';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord vétérinaire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-1">
                <a href="/index.html">
                    <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo" />
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
                    <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo" />
                </a>
            </div>
        </div>
    </div>
</header>

<main class="container mt-4">
    <h1 class="text-center mb-4">Bienvenue dans votre espace vétérinaire</h1>

    <!-- Message de succès ou d'erreur -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success text-center">
            <?= $_SESSION['message'] ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Affichage des informations d'alimentation des animaux -->
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="card-title">Historique d'alimentation des animaux</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Nourriture</th>
                        <th>Quantité (g)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alimentation as $al) : ?>
                        <tr>
                            <td><?= htmlspecialchars($al['Prenom']) ?></td>
                            <td><?= htmlspecialchars($al['DateAlimentation']) ?></td>
                            <td><?= htmlspecialchars($al['HeureAlimentation']) ?></td>
                            <td><?= htmlspecialchars($al['Nourriture']) ?></td>
                            <td><?= htmlspecialchars($al['Quantite']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulaire de comptes rendus vétérinaires -->
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="card-title">Comptes-rendus sur les animaux</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="animal"></label>
                    <select id="animal" name="animal" class="form-control" required>
                        <option value="">Sélectionnez un animal</option>
                        <?php foreach ($animaux as $animal): ?>
                            <option value="<?= htmlspecialchars($animal['id']) ?>"><?= htmlspecialchars($animal['Prenom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="etat_animal">État de l'animal</label>
                    <input type="text" id="etat_animal" name="etat_animal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nourriture">Nourriture proposée</label>
                    <input type="text" id="nourriture" name="nourriture" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="grammage">Grammage</label>
                    <input type="number" id="grammage" name="grammage" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="date_passage">Date de passage</label>
                    <input type="date" id="date_passage" name="date_passage" class="form-control" required>
                </div>
                <button type="submit" name="submit_compte_rendu" class="btn btn-primary">Ajouter le compte rendu</button>
            </form>
        </div>
    </div>

    <!-- Formulaire de commentaires sur les habitats -->
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="card-title">Commentaires sur les habitats</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="habitat">Habitat</label>
                    <select id="habitat" name="habitat" class="form-control" required>
                        <option value="">Sélectionnez un habitat</option>
                        <?php foreach ($habitats as $habitat): ?>
                            <option value="<?= htmlspecialchars($habitat['NomHabitat']) ?>"><?= htmlspecialchars($habitat['NomHabitat']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="commentaire">Commentaire</label>
                    <textarea id="commentaire" name="commentaire" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="date_commentaire">Date du commentaire</label>
                    <input type="date" id="date_commentaire" name="date_commentaire" class="form-control" required>
                </div>
                <button type="submit" name="submit_commentaire" class="btn btn-primary">Ajouter le commentaire</button>
            </form>
        </div>
    </div>
</main>

<footer>
    <ul>
        <li class="nav-item">
            <a href="/index.html" class="nav-link" style="font-size: 20px">&copy; 2024 Arcadia Zoo</a>
        </li>
    </ul>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
