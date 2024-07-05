<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['userType']) || ($_SESSION['userType'] !== 'administrateur' && $_SESSION['userType'] !== 'employe')) {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php'; // Assurez-vous d'inclure correctement config.php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $idService = $_GET['id'];

    $sql = "SELECT * FROM Services WHERE IdService = :idService";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idService', $idService);
    $stmt->execute();

    $service = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $idService = $_POST['id'];
    $nomService = isset($_POST['service_name']) ? trim($_POST['service_name']) : null;
    $descriptionService = isset($_POST['service_description']) ? trim($_POST['service_description']) : null;

    // Vérification des champs requis
    if (empty($nomService) || empty($descriptionService)) {
        $_SESSION['message'] = "Veuillez remplir tous les champs requis.";
        $_SESSION['msg_type'] = "danger";
        header("Location: admin_dashboard.php");
        exit();
    }

    // Gestion de l'image
    $imagePath = null;
    if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['service_image']['name'];
        $imageTmpName = $_FILES['service_image']['tmp_name'];
        $uploadDir = '/uploads/';
        $imagePath = $uploadDir . basename($imageFileName);

        // Déplacez l'image vers le répertoire d'upload sur votre serveur
        if (!move_uploaded_file($imageTmpName, $_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
            $_SESSION['message'] = "Erreur lors du téléchargement de l'image.";
            $_SESSION['msg_type'] = "danger";
            header("Location: admin_dashboard.php");
            exit();
        }
    }

    // Mise à jour dans la base de données
    try {
        $sql = "UPDATE Services SET NomService = :nomService, DescriptionService = :descriptionService";
        if ($imagePath !== null) {
            $sql .= ", ImageService = :imagePath";
        }
        $sql .= " WHERE IdService = :idService";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idService', $idService);
        $stmt->bindParam(':nomService', $nomService);
        $stmt->bindParam(':descriptionService', $descriptionService);
        if ($imagePath !== null) {
            $stmt->bindParam(':imagePath', $imagePath);
        }

        if ($stmt->execute()) {
            $_SESSION['message'] = "Le service a été mis à jour avec succès.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la mise à jour du service : " . implode(" ", $stmt->errorInfo());
            $_SESSION['msg_type'] = "danger";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur de base de données : " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: admin_dashboard.php");  // Redirige vers la page d'administration après l'opération
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le service</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-1">
                    <a href="index.html">
                        <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo"/>
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
                                <a href="/public/habitats.html" class="nav-link" style="font-size: 20px">Nos Habitats</a>
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
                        <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo"/>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <h1>Modifier le service</h1>
        <form action="edit_service.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($service['IdService']); ?>">
            <div class="form-group">
                <label for="service_name">Nom du service :</label>
                <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service['NomService']); ?>" required>
            </div>
            <div class="form-group">
                <label for="service_description">Description du service :</label>
                <textarea class="form-control" id="service_description" name="service_description" rows="3" required><?php echo htmlspecialchars($service['DescriptionService']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="service_image">Image du service :</label>
                <input type="file" class="form-control-file" id="service_image" name="service_image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Arcadia Zoo</p>
    </footer>
</body>
</html>
