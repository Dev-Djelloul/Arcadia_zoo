<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../back-end-php/config.php'; // Vérifiez bien le chemin pour inclure correctement config.php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username'])) {
    $username = $_GET['username'];

    // Récupérer les informations de l'utilisateur à éditer
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $userType = $_POST['userType'];

    try {
        // Mettre à jour le type d'utilisateur
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
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <h1>Modifier Utilisateur</h1>
    </header>
    <main class="container mt-4">
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
                    <option value="employe" <?= $user['TypeUtilisateur'] == 'employe' ? 'selected' : '' ?>>Employé</option>
                    <option value="veterinaire" <?= $user['TypeUtilisateur'] == 'veterinaire' ? 'selected' : '' ?>>Vétérinaire</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Arcadia Zoo</p>
    </footer>
</body>
</html>
