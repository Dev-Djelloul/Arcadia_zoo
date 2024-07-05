<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';  // Vérifiez bien le chemin pour inclure correctement config.php
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
                <a href="index.html">
                    <img
                        src="/assets/images/logo-arcadia.jpeg"
                        alt="Logo Arcadia Zoo"
                        class="logo"
                    />
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
                    <img
                        src="/assets/images/logo-arcadia.jpeg"
                        alt="Logo Arcadia Zoo"
                        class="logo"
                    />
                </a>
            </div>
        </div>
    </div>
</header>

<h1>Bienvenue dans votre espace administrateur</h1>

<main class="container mt-4">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['msg_type']); ?>
        </div>
    <?php endif; ?>

    <h2>Gérer les utilisateurs</h2>
    <form action="create_user.php" method="post">
        <div class="form-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="userType">Type d'utilisateur :</label>
            <select class="form-control" id="userType" name="userType" required>
                <option value="employe">Employé</option>
                <option value="veterinaire">Vétérinaire</option>
                <option value="administrateur">Administrateur</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
    </form>

    <!-- Table des utilisateurs existants -->
    <h2>Liste des utilisateurs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Type d'utilisateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_users = "SELECT * FROM Utilisateur";
            $stmt_users = $conn->query($sql_users);
            while ($row = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['Username']}</td>";
                echo "<td>{$row['TypeUtilisateur']}</td>";
                echo "<td>";
                echo "<a href='edit_user.php?username={$row['Username']}' class='btn btn-warning'>Modifier</a> ";
                echo "<a href='delete_user.php?username={$row['Username']}' class='btn btn-danger'>Supprimer</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <hr>

    <h2>Gérer les services</h2>
    <form action="/back-end-php/users/admin/create_service.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="service_name">Nom du service :</label>
        <input type="text" class="form-control" id="service_name" name="service_name" required>
    </div>
    <div class="form-group">
        <label for="service_description">Description du service :</label>
        <textarea class="form-control" id="service_description" name="service_description" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="service_image">Image du service :</label>
        <input type="file" class="form-control-file" id="service_image" name="service_image" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Ajouter le service</button>
</form>


    <!-- Table des services existants -->
    <h2>Liste des services</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nom du service</th>
                <th>Description du service</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_services = "SELECT * FROM Services";
            $stmt_services = $conn->query($sql_services);
            while ($row = $stmt_services->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['NomService']}</td>";
                echo "<td>{$row['DescriptionService']}</td>";
                echo "<td>";
                echo "<a href='edit_service.php?id={$row['IdService']}' class='btn btn-warning'>Modifier</a> ";
                echo "<a href='delete_service.php?id={$row['IdService']}' class='btn btn-danger'>Supprimer</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<footer>
    <p>&copy; 2024 Arcadia Zoo</p>
</footer>

</body>
</html>
