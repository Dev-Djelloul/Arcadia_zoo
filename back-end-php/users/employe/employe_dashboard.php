<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'employe') {
    header("Location: " . app_path("/public/connexion.html"));
    exit();
}
require '../../config.php'; // Inclusion de la connexion à la base de données
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace personnel - Employé</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-XDw1Ua9p9LxD4XK9Lc9/7ifdSvMwzz55IviNdZ+rzxgC+SZIZCcU4p3KLJZGKQ0+7MO9Dp8CemixjLRGYKs+0w==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-1">
                <a href="index.html">
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

<h1 style="margin: 50px">Bienvenue dans votre espace employé</h1>

<div class="container mt-5">
    <!-- Section de gestion des avis -->
    <section id="gererAvis" class="container mt-5">
        <h2 class="text-center">Gestion des avis des visiteurs</h2>
        <div id="avisEnAttente" class="row justify-content-center">
            <!-- Les avis en attente seront affichés ici -->
        </div>
    </section>
</div>
     
<!-- Section de gestion des services du zoo -->
<main class="container mt-4">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['msg_type']); ?>
        </div>
    <?php endif; ?>




    <!-- Ajout du formulaire pour l'alimentation des animaux -->
<h2>Gestion de l'alimentation quotidienne des animaux</h2>
<form action="alimentation_animaux.php" method="post">
    <div class="form-group">
        <label for="prenom">Prénom de l'animal :</label>
        <select class="form-control" id="prenom" name="prenom" required>
            <?php
            $sql_animaux = "SELECT Prenom FROM Animal";
            $stmt_animaux = $conn->query($sql_animaux);
            while ($row = $stmt_animaux->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['Prenom']}'>{$row['Prenom']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="date">Date :</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="form-group">
        <label for="heure">Heure :</label>
        <input type="time" class="form-control" id="heure" name="heure" required>
    </div>
    <div class="form-group">
        <label for="nourriture">Nourriture :</label>
        <input type="text" class="form-control" id="nourriture" name="nourriture" required>
    </div>
    <div class="form-group">
        <label for="quantite">Quantité (en grammes) :</label>
        <input type="number" class="form-control" id="quantite" name="quantite" required>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

    <h2>Gestion des services du parc</h2>
    <form action="/back-end-php/users/employe/create_service_employe.php" method="post" enctype="multipart/form-data">
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
<h2>Liste des services du parc</h2>
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
            $imagePath = htmlspecialchars(app_path($row['ImageService']));
            echo "<td><img src='{$imagePath}' alt='Image du service' style='max-width: 100px;'></td>";
            echo "<td>";
            echo "<a href='edit_service_employe.php?id={$row['IdService']}' class='btn btn-warning'>Modifier</a> ";
            echo "<a href='delete_service_employe.php?id={$row['IdService']}' class='btn btn-danger'>Supprimer</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

 

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Charger les avis en attente de validation
        $.ajax({
            type: "GET",
            url: "/back-end-php/employe_espace/gererAvis.php",
            dataType: "json",
            success: function(avis) {
                avis.forEach(function(avi) {
                    var avisHtml = `
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p class="card-text">${avi.avis}</p>
                                    <p class="card-text"><small class="text-muted">- ${avi.pseudo}</small></p>
                                    <button class="btn btn-success approuverAvis" data-id="${avi.id}">Approuver</button>
                                    <button class="btn btn-danger rejeterAvis" data-id="${avi.id}">Rejeter</button>
                                </div>
                            </div>
                        </div>
                    `;
                    $("#avisEnAttente").append(avisHtml);
                });
            },
            error: function(xhr, status, error) {
                alert("Erreur lors du chargement des avis.");
            }
        });

        // Approuver ou rejeter un avis
        $(document).on("click", ".approuverAvis, .rejeterAvis", function() {
            var id = $(this).data("id");
            var approuve = $(this).hasClass("approuverAvis") ? 1 : 0;

            $.ajax({
                type: "POST",
                url: "/back-end-php/employe_espace/gererAvis.php",
                data: { id: id, approuve: approuve },
                dataType: "json",
                success: function(response) {
                    alert(response.message);
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    alert("Erreur lors de la mise à jour de l'avis.");
                }
            });
        });
    });
</script>

<footer>
<ul>
<li class="nav-item">
<a href="/index.html" class="nav-link" style="font-size: 20px">&copy; 2024 Arcadia Zoo</a>
</li>
</ul>
</footer>
</body>
</html>
