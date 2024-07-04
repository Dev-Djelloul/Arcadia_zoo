<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: /public/connexion.html");
    exit;
}

require '../../config.php';

// Ajout d'un service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO Service (Nom, Description) VALUES (:nom, :description)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
}

// Suppression d'un service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_service'])) {
    $id = $_POST['service_id'];

    $stmt = $conn->prepare("DELETE FROM Service WHERE ID = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Modification d'un service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_service'])) {
    $id = $_POST['service_id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE Service SET Nom = :nom, Description = :description WHERE ID = :id");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

$services = $conn->query("SELECT * FROM Service")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Services</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Gestion des Services</h2>

        <form action="manage_services.php" method="post">
            <h3>Ajouter un service</h3>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <button type="submit" name="add_service" class="btn btn-primary">Ajouter</button>
        </form>

        <h3 class="mt-4">Services Existants</h3>
        <ul class="list-group">
            <?php foreach ($services as $service): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($service['Nom']); ?></strong>
                    <p><?php echo htmlspecialchars($service['Description']); ?></p>
                    <form action="manage_services.php" method="post" class="d-inline-block">
                        <input type="hidden" name="service_id" value="<?php echo $service['ID']; ?>">
                        <button type="submit" name="delete_service" class="btn btn-danger">Supprimer</button>
                    </form>
                    <button class="btn btn-info" onclick="showEditForm(<?php echo $service['ID']; ?>, '<?php echo htmlspecialchars($service['Nom']); ?>', '<?php echo htmlspecialchars($service['Description']); ?>')">Modifier</button>
                </li>
            <?php endforeach; ?>
        </ul>

        <div id="editForm" style="display: none;">
            <h3 class="mt-4">Modifier un service</h3>
            <form action="manage_services.php" method="post">
                <input type="hidden" id="editServiceId" name="service_id">
                <div class="form-group">
                    <label for="editNom">Nom :</label>
                    <input type="text" class="form-control" id="editNom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="editDescription">Description :</label>
                    <input type="text" class="form-control" id="editDescription" name="description" required>
                </div>
                <button type="submit" name="edit_service" class="btn btn-primary">Modifier</button>
                <button type="button" class="btn btn-secondary" onclick="hideEditForm()">Annuler</button>
            </form>
        </div>
        
        <a href="admin_dashboard.php" class="btn btn-secondary mt-4">Retour au tableau de bord</a>
    </div>

    <script>
        function showEditForm(id, nom, description) {
            document.getElementById('editServiceId').value = id;
            document.getElementById('editNom').value = nom;
            document.getElementById('editDescription').value = description;
            document.getElementById('editForm').style.display = 'block';
        }

        function hideEditForm() {
            document.getElementById('editForm').style.display = 'none';
        }
    </script>
</body>
</html>
