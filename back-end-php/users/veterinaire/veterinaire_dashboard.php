<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'veterinaire') {
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

<body>
    <h1>Bienvenue dans votre espace vétérinaire</h1>



<footer>
<ul>
<li class="nav-item">
<a href="/index.html" class="nav-link" style="font-size: 20px">&copy; 2024 Arcadia Zoo</a>
</li>
</ul>
</footer>
</body>
</html>
