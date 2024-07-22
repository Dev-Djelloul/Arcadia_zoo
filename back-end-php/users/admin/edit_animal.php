<?php
session_start();

// Vérification du type d'utilisateur
if (!isset($_SESSION['userType']) || ($_SESSION['userType'] !== 'administrateur' && $_SESSION['userType'] !== 'employe')) {
    header("Location: /public/connexion.html");
    exit();
}

// Inclusion du fichier de configuration pour la connexion à la base de données
require '../../config.php';

// Récupération des données de l'animal à éditer
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Sélection de l'animal à éditer
        $stmt = $conn->prepare("SELECT * FROM Animal WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $animal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$animal) {
            $_SESSION['message'] = "Animal non trouvé.";
            $_SESSION['msg_type'] = "danger";
            header("Location: admin_dashboard.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur de base de données : " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
        header("Location: admin_dashboard.php");
        exit();
    }
} else {
    $_SESSION['message'] = "ID d'animal non spécifié.";
    $_SESSION['msg_type'] = "danger";
    header("Location: admin_dashboard.php");
    exit();
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST['prenom'] ?? '';
    $race = $_POST['race'] ?? '';
    $imageAnimal = $animal['ImageAnimal']; // Conserver l'image existante par défaut
    $nomHabitat = $_POST['nomHabitat'] ?? '';

    // Vérification des champs requis
    if (empty($prenom) || empty($race) || empty($nomHabitat)) {
        $_SESSION['message'] = "Veuillez remplir tous les champs requis.";
        $_SESSION['msg_type'] = "danger";
        header("Location: admin_dashboard.php");
        exit();
    }

    // Gestion de l'image si une nouvelle image est téléchargée
    if (!empty($_FILES['imageAnimal']['name']) && $_FILES['imageAnimal']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['imageAnimal']['name'];
        $imageTmpName = $_FILES['imageAnimal']['tmp_name'];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        $imagePath = $uploadDir . basename($imageFileName);

        // Déplacement de la nouvelle image
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            $_SESSION['message'] = "Erreur lors du téléchargement de l'image.";
            $_SESSION['msg_type'] = "danger";
            header("Location: admin_dashboard.php");
            exit();
        }

        $imageAnimal = "/uploads/" . basename($imageFileName);
    }

    try {
        // Mise à jour de l'animal dans la base de données
        $sql = "UPDATE Animal SET Prenom = :prenom, Race = :race, ImageAnimal = :imageAnimal, NomHabitat = :nomHabitat WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':race', $race);
        $stmt->bindParam(':imageAnimal', $imageAnimal);
        $stmt->bindParam(':nomHabitat', $nomHabitat);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Animal mis à jour avec succès.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la mise à jour de l'animal : " . $stmt->errorInfo()[2];
            $_SESSION['msg_type'] = "danger";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur de base de données : " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }

    // Redirection vers la page d'accueil
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!-- Formulaire d'édition de l'animal -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Édition de l'animal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-1">
                <a href="index.html">
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
    <h1>Édition de l'animal</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['msg_type']); ?>
        </div>
    <?php endif; ?>

    <form action="edit_animal.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="prenom">Prénom de l'animal :</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($animal['Prenom']); ?>" required>
        </div>
        <div class="form-group">
            <label for="race">Race de l'animal :</label>
            <input type="text" class="form-control" id="race" name="race" value="<?php echo htmlspecialchars($animal['Race']); ?>" required>
        </div>
        <div class="form-group">
            <label for="imageAnimal">Image de l'animal :</label>
            <input type="file" class="form-control-file" id="imageAnimal" name="imageAnimal" accept="image/*">
            <?php if (!empty($animal['ImageAnimal'])): ?>
                <img src="<?php echo htmlspecialchars($animal['ImageAnimal']); ?>" alt="Image de l'animal" style="max-width: 100px;">
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="nomHabitat">Nom de l'habitat :</label>
            <select class="form-control" id="nomHabitat" name="nomHabitat" required>
                <?php
                $sql_habitats = "SELECT NomHabitat FROM Habitat";
                $stmt_habitats = $conn->query($sql_habitats);
                while ($row = $stmt_habitats->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($row['NomHabitat'] == $animal['NomHabitat']) ? "selected" : "";
                    echo "<option value=\"" . htmlspecialchars($row['NomHabitat']) . "\" $selected>" . htmlspecialchars($row['NomHabitat']) . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</main>

</body>
</html>
