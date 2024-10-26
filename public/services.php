<?php
require_once('../back-end-php/config.php');

$sql = "SELECT NomService, DescriptionService, ImageService FROM services"; // Assurez-vous que le nom de la table et des colonnes est correct
$result = $conn->query($sql);

// Debug : Affichage d'un message pour vérifier si la page se charge correctement
echo "Page services.php chargée avec succès.";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nos Services à Arcadia Zoo</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-XDw1Ua9p9LxD4XK9Lc9/7ifdSvMwzz55IviNdZ+rzxgC+SZIZCcU4p3KLJZGKQ0+7MO9Dp8CemixjLRGYKs+0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <header>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-1">
          <a href="/index.html">
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

  <div class="container mt-4">
    <h2 class="text-center mb-4">Une Journée bien remplie vous attend à Arcadia !</h2>
    <div class="row">
      <?php
      if ($result !== false && $result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <div class="col-md-6 mb-4">
            <div class="service">
              <?php
              if (!empty($row['ImageService'])) {
                echo '<img src="' . htmlspecialchars($row['ImageService']) . '" alt="' . htmlspecialchars($row['NomService']) . '" class="img-fluid" />';
              } else {
                echo '<img src="/assets/images/default-service-image.jpg" alt="' . htmlspecialchars($row['NomService']) . '" class="img-fluid" />'; // Image par défaut si aucune image spécifiée
              }
              ?>
              <h3><?php echo htmlspecialchars($row['NomService']); ?></h3>
              <p><?php echo htmlspecialchars($row['DescriptionService']); ?></p>
            </div>
          </div>
          <?php
        }
      } else {
        ?>
        <p class="text-center">Aucun service disponible pour le moment.</p>
        <?php
      }
      ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="mb-4">
            <h6 class="text-center">Comment venir au parc zoologique d'Arcadia ?</h6>
            <p class="text-center text-white">
              Arcadia Zoo<br />
              123 Rue des Animaux<br />
              Ville des Animaux, 12345<br />
            </p>
          </div>
          <div>
            <h6 class="text-center">Nous contacter</h6>
            <p class="text-center text-white">
              Téléphone: 0123-456-789<br />
              Email: info.arcadiazoo@gmail.com
            </p>
          </div>
        </div>
        <div class="col-md-8 text-center">
          <div class="mb-4">
            <h6>Horaires d'ouverture</h6>
            <div class="row justify-content-center">
              <div class="col-md-6">
                <p class="text-white">Lundi à Vendredi</p>
                <p class="text-white">Samedi et Dimanche</p>
              </div>
              <div class="col-md-6">
                <p class="text-white">De 9h à 18h</p>
                <p class="text-white">De 9h à 20h</p>
              </div>
            </div>
            <div class="col-md-6">
              <p class="text-white">Fermé le mardi et les jours fériés</p>
            </div>
            <div>
              <h6>Suivez-nous</h6>
              <div class="d-flex justify-content-center">
                <a href="https://www.facebook.com/" class="social-icon mx-2"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="https://twitter.com/?lang=fr" class="social-icon mx-2"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="https://www.instagram.com/" class="social-icon mx-2"><i class="fab fa-instagram-square"></i> Instagram</a>
                <a href="https://www.linkedin.com/feed/" class="social-icon mx-2"><i class="fab fa-linkedin"></i> Linkedin</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>

<?php
// Fermeture de la connexion à la base de données
$conn = null;
?>
