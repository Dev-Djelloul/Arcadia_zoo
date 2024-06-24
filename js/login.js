$(document).ready(function () {
  $("#loginForm").submit(function (event) {
    event.preventDefault(); // Empêche le formulaire de se soumettre normalement

    var username = $("#username").val();
    var password = $("#password").val();

    $.ajax({
      url: "http://localhost:3005/login", // Mettez à jour avec votre URL correcte
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify({ username: username, password: password }),
      success: function (response) {
        if (response.success) {
          // Connexion réussie, affichez un message de succès en vert
          $("#loginMessage")
            .removeClass("error-message")
            .addClass("success-message")
            .text(response.message);
          // Redirection ou autres actions selon besoin
        } else {
          // Connexion échouée, affichez un message d'erreur en rouge sur deux lignes
          $("#loginMessage")
            .removeClass("success-message")
            .addClass("error-message")
            .text(
              "Nom utilisateur ou mot de passe incorrect.\nConnexion échouée ! Veuillez réessayer."
            );
        }
      },
      error: function (xhr, status, error) {
        console.error("Erreur lors de la requête de connexion:", error);
        // Affichez un message d'erreur en rouge sur deux lignes pour les erreurs HTTP
        $("#loginMessage")
          .removeClass("success-message")
          .addClass("error-message")
          .text(
            "Nom utilisateur ou mot de passe incorrect.\nVeuillez vérifier votre connexion et réessayer."
          );
      },
    });
  });
});
