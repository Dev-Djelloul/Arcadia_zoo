$(document).ready(function() {
    // Soumission du formulaire pour ajouter un nouvel animal
    $('#addAnimalForm').on('submit', function(event) {
      event.preventDefault();
      const especeAnimal = $('#especeAnimal').val();
      const habitat = $('#habitat').val();
      const regimeAlimentaire = $('#regimeAlimentaire').val();
  
      $.ajax({
        url: '/employe/nouvel-animal',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ especeAnimal, habitat, regimeAlimentaire }),
        success: function(response) {
          alert(response.message);
          $('#addAnimalForm')[0].reset(); // Réinitialisation du formulaire après succès
        },
        error: function(error) {
          alert('Erreur lors de l\'ajout du nouvel animal');
        }
      });
    });
  
    // Soumission du formulaire pour ajouter une alimentation
    $('#addAlimentationForm').on('submit', function(event) {
      event.preventDefault();
      const animalName = $('#animalName').val();
      const date = $('#date').val();
      const time = $('#time').val();
      const food = $('#food').val();
      const quantity = $('#quantity').val();
  
      $.ajax({
        url: '/employe/alimentation',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ animalName, date, time, food, quantity }),
        success: function(response) {
          alert(response.message);
          $('#addAlimentationForm')[0].reset(); // Réinitialisation du formulaire après succès
        },
        error: function(error) {
          alert('Erreur lors de l\'ajout de l\'alimentation');
        }
      });
    });
  
    // Soumission du formulaire pour ajouter un service
    $('#addServiceForm').on('submit', function(event) {
      event.preventDefault();
      const serviceName = $('#serviceName').val();
      const serviceDescription = $('#serviceDescription').val();
  
      $.ajax({
        url: '/employe/services',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ serviceName, serviceDescription }),
        success: function(response) {
          alert(response.message);
          $('#addServiceForm')[0].reset(); // Réinitialisation du formulaire après succès
        },
        error: function(error) {
          alert('Erreur lors de l\'ajout du service');
        }
      });
    });
  
    // Soumission du formulaire pour valider un avis
    $('#validateAvisForm').on('submit', function(event) {
      event.preventDefault();
      const avisId = $('#avisId').val();
      const valide = true; // Définir la valeur correcte pour la validation de l'avis
  
      $.ajax({
        url: '/employe/avis',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ avisId, valide }),
        success: function(response) {
          alert(response.message);
          $('#validateAvisForm')[0].reset(); // Réinitialisation du formulaire après succès
        },
        error: function(error) {
          alert('Erreur lors de la validation de l\'avis');
        }
      });
    });
  
    // Autres fonctions existantes pour les autres formulaires...
  });
  