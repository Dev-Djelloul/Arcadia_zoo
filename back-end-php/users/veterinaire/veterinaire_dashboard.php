<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'veterinaire') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';

// Récupération des animaux depuis la base de données
$sql_animaux = "SELECT id, Prenom FROM Animal";
$stmt_animaux = $conn->prepare($sql_animaux);
$stmt_animaux->execute();
$animaux = $stmt_animaux->fetchAll(PDO::FETCH_ASSOC);

// Récupération des habitats depuis la base de données
$sql_habitats = "SELECT id, NomHabitat FROM Habitat";
$stmt_habitats = $conn->prepare($sql_habitats);
$stmt_habitats->execute();
$habitats = $stmt_habitats->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire de saisie de compte rendu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idAnimal'], $_POST['etatAnimal'], $_POST['nourriture'], $_POST['grammage'], $_POST['datePassage'])) {
    // Récupération des données du formulaire
    $idAnimal = $_POST['idAnimal'];
    $etatAnimal = $_POST['etatAnimal'];
    $nourriture = $_POST['nourriture'];
    $grammage = $_POST['grammage'];
    $datePassage = $_POST['datePassage'];

    // Insertion dans la base de données
    $sql_insert = "INSERT INTO ComptesRendusVeterinaires (Prenom, EtatAnimal, Nourriture, Grammage, DatePassage) VALUES (:idAnimal, :etatAnimal, :nourriture, :grammage, :datePassage)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bindParam(':idAnimal', $idAnimal);
    $stmt_insert->bindParam(':etatAnimal', $etatAnimal);
    $stmt_insert->bindParam(':nourriture', $nourriture);
    $stmt_insert->bindParam(':grammage', $grammage);
    $stmt_insert->bindParam(':datePassage', $datePassage);
    
    if ($stmt_insert->execute()) {
        $_SESSION['message'] = "Le compte rendu a été ajouté avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de l'ajout du compte rendu.";
    }
    header("Location: veterinaire_dashboard.php");
    exit();
}

// Traitement du formulaire de commentaire d'habitat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idHabitat'], $_POST['commentaire'])) {
    // Récupération des données du formulaire
    $idHabitat = $_POST['idHabitat'];
    $commentaire = $_POST['commentaire'];
    $dateCommentaire = date('Y-m-d'); 

    // Insertion dans la base de données 
    $sql_insert = "INSERT INTO CommentairesHabitats (NomHabitat, Commentaires, DateCommentaire) VALUES (:idHabitat, :commentaire, :dateCommentaire)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bindParam(':idHabitat', $idHabitat);
    $stmt_insert->bindParam(':commentaire', $commentaire);
    $stmt_insert->bindParam(':dateCommentaire', $dateCommentaire);
    
    if ($stmt_insert->execute()) {
        $_SESSION['message'] = "Le commentaire a été ajouté avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de l'ajout du commentaire.";
    }

    header("Location: veterinaire_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord administrateur</title>
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

    <!-- Formulaire pour saisir un compte rendu -->
    <div class="card">
      <div class="card-body">
        <h2 class="card-title">Saisir le compte rendu sur l'animal : </h2>
        <form action="veterinaire_dashboard.php" method="POST">
            <div class="form-group">
                <label for="idAnimal">Animal :</label>
                <select class="form-control" name="idAnimal" id="idAnimal">
                    <?php foreach ($animaux as $animal): ?>
                        <option value="<?= $animal['id'] ?>"><?= $animal['Prenom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="etatAnimal">État de l'animal :</label>
                <input type="text" class="form-control" name="etatAnimal" id="etatAnimal" required>
            </div>
            <div class="form-group">
                <label for="nourriture">Nourriture :</label>
                <input type="text" class="form-control" name="nourriture" id="nourriture" required>
            </div>
            <div class="form-group">
                <label for="grammage">Grammage :</label>
                <input type="number" class="form-control" name="grammage" id="grammage" required>
            </div>
            <div class="form-group">
                <label for="datePassage">Date de passage :</label>
                <input type="date" class="form-control" name="datePassage" id="datePassage" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le compte rendu</button>
        </form>
      </div>
    </div>

    <!-- Formulaire pour commenter un habitat -->
    <div class="card mt-4">
      <div class="card-body">
        <h2 class="card-title">Commentaires sur un habitat :</h2>
        <form action="veterinaire_dashboard.php" method="POST">
            <div class="form-group">
                <label for="idHabitat">Habitat :</label>
                <select class="form-control" name="idHabitat" id="idHabitat">
                    <?php foreach ($habitats as $habitat): ?>
                        <option value="<?= $habitat['id'] ?>"><?= $habitat['NomHabitat'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="commentaire">Commentaire :</label>
                <textarea class="form-control" name="commentaire" id="commentaire" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le commentaire</button>
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
