<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';
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

<h1>Bienvenue dans votre espace administrateur</h1>

<main class="container mt-4">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['msg_type']); ?>
        </div>
    <?php endif; ?>

    <!-- Gestion des utilisateurs -->
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
                <option value="administrateur">Administrateur</option>
                <option value="employe">Employé</option>
                <option value="veterinaire">Vétérinaire</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Création d'un nouvel utilisateur</button>
    </form>

    <!-- Liste des utilisateurs existants -->
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
    <!-- Gestion des services -->
    <h2>Gérer les services</h2>
    <form action="create_service.php" method="post" enctype="multipart/form-data">
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

<!-- Liste des services existants -->
<h2>Liste des services</h2>
<table class="table">
    <thead>
        <tr>
            <th>Nom du service</th>
            <th>Description du service</th>
            <th>Image du service</th>
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
            echo "<td><img src='{$row['ImageService']}' alt='Image du service' style='max-width: 100px;'></td>";
            echo "<td>";
            echo "<a href='edit_service.php?id={$row['IdService']}' class='btn btn-warning'>Modifier</a> ";
            echo "<a href='delete_service.php?id={$row['IdService']}' class='btn btn-danger'>Supprimer</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>



<!-- Gestion des habitats -->
<h2>Gérer les habitats</h2>
<form action="create_habitats.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="nomHabitat">Nom de l'Habitat :</label>
        <input type="text" class="form-control" id="nomHabitat" name="nomHabitat" required>
    </div>
    <div class="form-group">
        <label for="descriptionHabitat">Description de l'Habitat :</label>
        <textarea class="form-control" id="descriptionHabitat" name="descriptionHabitat" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="imageHabitat">Image de l'Habitat :</label>
        <input type="file" class="form-control-file" id="imageHabitat" name="imageHabitat" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Ajouter l'Habitat</button>
</form>

<!-- Table des habitats existants -->
<h2>Liste des habitats</h2>
<table class="table">
    <thead>
        <tr>
            <th>Nom de l'Habitat</th>
            <th>Description de l'Habitat</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql_habitats = "SELECT * FROM Habitat";
        $stmt_habitats = $conn->query($sql_habitats);
        while ($row = $stmt_habitats->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['NomHabitat']}</td>";
            echo "<td>{$row['DescriptionHabitat']}</td>";
            echo "<td><img src='{$row['ImageHabitat']}' alt='Image' style='max-width: 100px;'></td>";
            echo "<td>";
            echo "<a href='edit_habitats.php?id={$row['id']}' class='btn btn-warning'>Modifier</a> ";
            echo "<a href='delete_habitats.php?id={$row['id']}' class='btn btn-danger'>Supprimer</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
</main>

<footer>
<ul>
<li class="nav-item">
<a href="/index.html" class="nav-link" style="font-size: 20px">&copy; 2024 Arcadia Zoo</a>
</li>
</ul>
</footer>
</body>
</html>
