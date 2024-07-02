<?php
require_once '../config.php';
require_once 'services.php';
require_once 'animaux.php';
require_once 'habitats.php';
require_once 'horaires.php';

// Exemple de lecture des services
$services = getAllServices($conn);

// Affichage des services
echo "<h2>Liste des Services</h2>";
echo "<ul>";
foreach ($services as $service) {
    echo "<li>{$service['nom']} - {$service['description']}</li>";
}
echo "</ul>";

// Formulaire de création de service
?>
<h2>Créer un nouveau service</h2>
<form action="creerService.php" method="post">
    <label>Nom du service:</label>
    <input type="text" name="nom_service" required><br><br>
    <label>Description:</label><br>
    <textarea name="description_service" rows="4" cols="50" required></textarea><br><br>
    <input type="submit" value="Créer">
</form>
