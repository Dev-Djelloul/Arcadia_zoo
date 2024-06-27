$(document).ready(function() {
  // Gérer la soumission du formulaire de connexion
  $('#loginForm').on('submit', function(event) {
    event.preventDefault(); // Empêche le rechargement de la page par défaut

    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
      url: 'http://localhost:3005/login',
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        username: username,
        password: password
      }),
      success: function(response) {
        if (response.success) {
          $('#loginMessage').css('color', 'green');
          $('#loginMessage').html('Connexion réussie ! Bienvenue ' + username + '.');
          // Redirige en fonction du type d'utilisateur
          if (response.userType === 'administrateur') {
            window.location.href = 'http://localhost:3005/admin';
          } else if (response.userType === 'veterinaire') {
            window.location.href = 'http://localhost:3005/veterinaire';
          } else if (response.userType === 'employe') {
            window.location.href = 'http://localhost:3005/employe';
          } else {
            // Si l'utilisateur est un visiteur, redirige vers la page d'accueil
            window.location.href = 'http://localhost:3005/index.html';
          }
        } else {
          $('#loginMessage').css('color', 'red');
          $('#loginMessage').html('Nom utilisateur ou mot de passe incorrect.<br>Connexion échouée ! Veuillez réessayer.');
        }
      },
      error: function(xhr, status, error) {
        console.error('Erreur lors de la requête de connexion:', error);
        $('#loginMessage').css('color', 'red');
        $('#loginMessage').html('Une erreur est survenue.<br>Veuillez réessayer.');
      }
    });
  });

  // Ouvrir la fenêtre modale pour soumettre un avis
  $('#openReviewPopup').on('click', function() {
    $('#reviewPopup').css('display', 'block');
  });

  // Fermer la fenêtre modale
  $('.close').on('click', function() {
    $('#reviewPopup').css('display', 'none');
  });

  // Fermer la fenêtre modale en cliquant en dehors du contenu
  $(window).on('click', function(event) {
    if ($(event.target).is('#reviewPopup')) {
      $('#reviewPopup').css('display', 'none');
    }
  });

  // Gérer la soumission du formulaire d'avis
  $('#reviewForm').on('submit', function(event) {
    event.preventDefault();

    var pseudo = $('#pseudo').val();
    var avis = $('#avis').val();

    $.ajax({
      url: 'http://localhost:3005/avis',
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        pseudo: pseudo,
        avis: avis
      }),
      success: function(response) {
        if (response.success) {
          alert('Votre avis a été soumis pour validation.');
          $('#reviewPopup').css('display', 'none');
          $('#reviewForm')[0].reset();
        } else {
          alert('Une erreur est survenue. Veuillez réessayer.');
        }
      },
      error: function(xhr, status, error) {
        console.error('Erreur lors de la soumission de l\'avis:', error);
        alert('Une erreur est survenue. Veuillez réessayer.');
      }
    });
  });
});
