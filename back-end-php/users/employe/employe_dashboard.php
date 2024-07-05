<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'employe') {
    header("Location: /public/connexion.html");
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Espace personnel - vétérinaire</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/assets/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-XDw1Ua9p9LxD4XK9Lc9/7ifdSvMwzz55IviNdZ+rzxgC+SZIZCcU4p3KLJZGKQ0+7MO9Dp8CemixjLRGYKs+0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <a href="/index.html" class="nav-link" style="font-size: 20px"
                  >Accueil</a
                >
              </li>
              <li class="nav-item">
                <a
                  href="/public/services.php"
                  class="nav-link"
                  style="font-size: 20px"
                  >Nos Services</a
                >
              </li>
              <li class="nav-item">
                <a
                  href="/public/habitats.html"
                  class="nav-link"
                  style="font-size: 20px"
                  >Nos Habitats</a
                >
              </li>
              <li class="nav-item">
                <a
                  href="/public/contact.html"
                  class="nav-link"
                  style="font-size: 20px"
                  >Contact</a
                >
              </li>
              <li class="nav-item" id="loginNavItem">
                <a
                  id="loginLink"
                  href="/public/connexion.html"
                  class="nav-link"
                  style="font-size: 20px"
                  >Connexion</a
                >
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

  <h1 style="margin: 50px">Bienvenue dans votre espace employé</h1>

  <div class="container mt-5">
    <!-- Section de gestion des avis -->
    <section id="gererAvis" class="container mt-5">
      <h2 class="text-center">Gestion des avis des visiteurs</h2>
      <div id="avisEnAttente" class="row justify-content-center">
        <!-- Les avis en attente seront affichés ici -->
      </div>
    </section>

    <!-- Section d'alimentation des animaux -->
    <section id="alimentationAnimaux" class="container mt-5">
      <h2 class="text-center">Consommation journalière des animaux</h2>
      <form id="formAlimentation">
        <div class="form-group">
          <label for="idAnimal">Sélectionner un animal :</label>
          <select class="form-control" id="idAnimal" name="idAnimal">
            <!-- Options pour les animaux à récupérer dynamiquement depuis la base de données -->
            <!-- Exemple statique : à remplacer par une génération dynamique -->
            <option value="1">Lion</option>
            <option value="2">Éléphant</option>
            <option value="3">Gorille</option>
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
          <label for="nourriture">Type de nourriture :</label>
          <input type="text" class="form-control" id="nourriture" name="nourriture" required>
        </div>
        <div class="form-group">
          <label for="quantite">Quantité :</label>
          <input type="number" class="form-control" id="quantite" name="quantite" required>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>
      </form>
    </section>

    <!-- Section de gestion des services du zoo -->
    <section id="servicesZoo" class="container mt-5">
      <h2 class="text-center">Modifier un service du zoo</h2>
      <form id="formServices">
        <div class="form-group">
          <label for="idService">Sélectionner un service :</label>
          <select class="form-control" id="idService" name="idService">
            <!-- Options pour les services à récupérer dynamiquement depuis la base de données -->
            <!-- Exemple statique : à remplacer par une génération dynamique -->
            <option value="1">Safari</option>
            <option value="2">Soins vétérinaires</option>
            <option value="3">Éducation des visiteurs</option>
          </select>
        </div>
        <div class="form-group">
          <label for="nouveauNom">Nouveau nom :</label>
          <input type="text" class="form-control" id="nouveauNom" name="nouveauNom" required>
        </div>
        <div class="form-group">
          <label for="nouvelleDescription">Nouvelle description :</label>
          <textarea class="form-control" id="nouvelleDescription" name="nouvelleDescription" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
      </form>
    </section>
  </div>

  <footer class="bg-dark text-white py-4 mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h6 class="text-center">
            Comment venir au parc zoologique d'Arcadia ?
          </h6>
          <p class="text-center text-white">
            Arcadia Zoo<br />
            123 Rue des Animaux<br />
            Ville des Animaux, 12345<br />
          </p>

          <h6 class="text-center">Nous contacter</h6>
          <p class="text-center text-white">
            Téléphone: 123-456-7890<br />
            Email: info.arcadiazoo@gmail.com
          </p>
        </div>
        <div class="col-md-8">
          <h6 class="text-center">Suivez-nous :</h6>
          <div class="text-center">
            <a href="https://www.facebook.com/" class="social-icon"
              ><i class="fab fa-facebook"></i> Facebook</a
            >
            <a href="https://twitter.com/?lang=fr" class="social-icon"
              ><i class="fab fa-twitter"></i> Twitter</a
            >
            <a href="https://www.instagram.com/" class="social-icon"
              ><i class="fab fa-instagram-square"></i> Instagram</a
            >
            <a href="https://www.linkedin.com/feed/" class="social-icon"
              ><i class="fab fa-linkedin"></i> Linkedin</a
            >
          </div>
        </div>
      </div>
    </div>
  </footer>

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

      // Soumission du formulaire d'alimentation des animaux
      $("#formAlimentation").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
          type: "POST",
          url: "/back-end-php/employe_espace/alimentationAnimaux.php",
          data: formData,
          dataType: "json",
          success: function(response) {
            alert(response.message);
            if (response.success) {
              $("#formAlimentation")[0].reset();
            }
          },
          error: function(xhr, status, error) {
            alert("Erreur lors de l'ajout de la consommation d'alimentation.");
          }
        });
      });

      // Soumission du formulaire de modification des services
      $("#formServices").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
          type: "POST",
          url: "/back-end-php/employe_espace/servicesZoo.php",
          data: formData,
          dataType: "json",
          success: function(response) {
            alert(response.message);
            if (response.success) {
              $("#formServices")[0].reset();
            }
          },
          error: function(xhr, status, error) {
            alert("Erreur lors de la modification du service.");
          }
        });
      });
    });
  </script>
</body>
</html>