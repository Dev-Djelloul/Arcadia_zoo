$(document).ready(function() {
  // Soumission du formulaire pour créer un employé
  $('#creerEmployeForm').submit(function(event) {
    event.preventDefault();
    
    var email = $('#emailEmploye').val();
    var password = $('#passwordEmploye').val();

    console.log('Creating employee with email:', email, 'and password:', password);

    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          alert(response.message);
        } else {
          console.error('Erreur serveur:', response.error); // Afficher les erreurs du serveur dans la console
          alert(response.error);
        }
      },
      error: function (xhr, status, error) {
        console.error('Erreur AJAX:', xhr.responseText); // Afficher les erreurs de requête dans la console
        alert("Une erreur s'est produite. Veuillez réessayer.");
      },
    });
  });
});

    $.ajax({
      url: '/back-end-php/admin_espace/creerEmploye.php', 
      method: 'POST',
      dataType: 'json',
      data: {
        email: email,
        password: password
      },
      success: function(response) {
        console.log('Response:', response);
        alert(response.message);
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
        alert('Erreur lors de la création de l\'employé : ' + error);
      }
    });
  

  // Soumission du formulaire pour créer un vétérinaire
  $('#creerVeterinaireForm').submit(function(event) {
    event.preventDefault();
    
    var email = $('#emailVeterinaire').val();
    var password = $('#passwordVeterinaire').val();

    console.log('Creating veterinarian with email:', email, 'and password:', password);

    $.ajax({
      url: '/back-end-php/admin_espace/creerVeterinaire.php', 
      method: 'POST',
      dataType: 'json',
      data: {
        email: email,
        password: password
      },
      success: function(response) {
        console.log('Response:', response);
        alert(response.message);
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
        alert('Erreur lors de la création du vétérinaire : ' + error);
      }
    });
  });

