<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'employe') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php'; // Inclusion de la connexion à la base de données

// Récupération du service à modifier
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $idService = $_GET['id'];

    // Requête de récupération du service
    $sql = "SELECT * FROM Services WHERE IdService = :idService";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idService', $idService);
    $stmt->execute();

    $service = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $idService = $_POST['id'];
    $nomService = $_POST['service_name'];
    $descriptionService = $_POST['service_description'];


    // Vérification des champs requis
    $sql = "UPDATE Services SET NomService = :nomService, DescriptionService = :descriptionService WHERE IdService = :idService";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idService', $idService);
    $stmt->bindParam(':nomService', $nomService);
    $stmt->bindParam(':descriptionService', $descriptionService);


    // Exécution de la requête
    if ($stmt->execute()) {
        $_SESSION['message'] = "Le service a été mis à jour avec succès.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de la mise à jour du service : " . $stmt->errorInfo()[2];
        $_SESSION['msg_type'] = "danger";
    }

    // Redirection vers la page d'administration
    header("Location: employe_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un service</title>
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
<div class="container mt-5">
    <h1>Modifier le service</h1>
    <form action="edit_service_employe.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($service['IdService']); ?>">
        <div class="form-group">
            <label for="service_name">Nom du service :</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service['NomService']); ?>" required>
        </div>
        <div class="form-group">
            <label for="service_description">Description du service :</label>
            <textarea class="form-control" id="service_description" name="service_description" rows="3" required><?php echo htmlspecialchars($service['DescriptionService']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
</body>
</html>
