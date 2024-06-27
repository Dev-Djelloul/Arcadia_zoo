// Fichier creationCompte.js

$(document).ready(function() {
    // Soumission du formulaire pour créer un employé
    $('#creerEmployeForm').on('submit', function(event) {
      event.preventDefault();
  
      var email = $('#emailEmploye').val();
      var password = $('#passwordEmploye').val();
  
      $.ajax({
        url: 'http://localhost:3005/creer-employe',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ email: email, password: password }),
        success: function(response) {
          if (response.success) {
            alert('Compte employé créé avec succès !');
            // Vous pouvez ajouter d'autres actions après la création du compte
          } else {
            alert('Erreur lors de la création du compte employé.');
          }
        },
        error: function(xhr, status, error) {
          console.error('Erreur lors de la création du compte employé :', error);
          alert('Une erreur est survenue lors de la création du compte employé. Veuillez réessayer.');
        }
      });
    });
  
    // Soumission du formulaire pour créer un vétérinaire
    $('#creerVeterinaireForm').on('submit', function(event) {
      event.preventDefault();
  
      var email = $('#emailVeterinaire').val();
      var password = $('#passwordVeterinaire').val();
  
      $.ajax({
        url: 'http://localhost:3005/creer-veterinaire',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ email: email, password: password }),
        success: function(response) {
          if (response.success) {
            alert('Compte vétérinaire créé avec succès !');
            // Vous pouvez ajouter d'autres actions après la création du compte
          } else {
            alert('Erreur lors de la création du compte vétérinaire.');
          }
        },
        error: function(xhr, status, error) {
          console.error('Erreur lors de la création du compte vétérinaire :', error);
          alert('Une erreur est survenue lors de la création du compte vétérinaire. Veuillez réessayer.');
        }
      });
    });
  });
  