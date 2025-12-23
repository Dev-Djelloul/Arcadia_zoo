<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: " . app_path("/public/connexion.html"));
    exit();
}

require '../../config.php'; // Inclusion de la connexion à la base de données


// Récupérer les informations de l'utilisateur à éditer
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username'])) {
    $username = $_GET['username'];

    // Récupérer l'utilisateur
    $sql = "SELECT * FROM Utilisateur WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['message'] = "Utilisateur non trouvé.";
        $_SESSION['msg_type'] = "danger";
        header("Location: admin_dashboard.php");
        exit();
    }
}

// Mettre à jour l'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $userType = $_POST['userType'];

    try {
        // Mettre à jour l'utilisateur dans la base de données
        $sql = "UPDATE Utilisateur SET TypeUtilisateur = ? WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userType, $username]);

        $_SESSION['message'] = "Utilisateur mis à jour avec succès.";
        $_SESSION['msg_type'] = "success";
        header("Location: admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur : " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
        header("Location: admin_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de l'utilisateur</title>
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
                        <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo"/>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <main class="container mt-4">
    <h1>Modifier l'utilisateur</h1>
        <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
            <?= $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
        </div>
        <?php endif ?>

        <form action="edit_user.php" method="post">
            <input type="hidden" name="username" value="<?= $user['Username'] ?>">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user['Username'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="userType">Type d'utilisateur :</label>
                <select class="form-control" id="userType" name="userType" required>
                <option value="administrateur" <?= $user['TypeUtilisateur'] == 'administrateur' ? 'selected' : '' ?>>Administrateur</option>
                    <option value="employe" <?= $user['TypeUtilisateur'] == 'employe' ? 'selected' : '' ?>>Employé</option>
                    <option value="veterinaire" <?= $user['TypeUtilisateur'] == 'veterinaire' ? 'selected' : '' ?>>Vétérinaire</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </main>
</body>
</html>
