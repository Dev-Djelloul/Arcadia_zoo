<?php
include('config.php');

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupére les données du formulaire
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    // Validation des données
    if (empty($nom) || empty($description) || empty($image)) {
        echo "Tous les champs sont requis.";
        exit;
    }

    // Échappe les caractères spéciaux pour prévenir les injections SQL
    $nom = mysqli_real_escape_string($conn, $nom);
    $description = mysqli_real_escape_string($conn, $description);
    $image = mysqli_real_escape_string($conn, $image);

    // Prépare la requête SQL pour insérer les données
    $sql = "INSERT INTO services (nom, description, image) VALUES ('$nom', '$description', '$image')";

    // Exécute la requête
    if (mysqli_query($conn, $sql)) {
        echo "Service ajouté avec succès.";
    } else {
        echo "Erreur: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Ferme la connexion
    mysqli_close($conn);
} else {
    echo "Méthode de requête invalide.";
}
?>
