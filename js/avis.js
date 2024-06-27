// avis.js

$(document).ready(function() {
    $("#reviewForm").submit(function(event) {
        event.preventDefault(); // Empêche le rechargement de la page

        var pseudo = $("#pseudo").val();
        var avis = $("#avis").val();

        // Envoi des données via AJAX
        $.ajax({
            type: "POST",
            url: "http://localhost:3005/avis", // URL de votre route Node.js pour gérer les avis
            data: {
                pseudo: pseudo,
                avis: avis
            },
            success: function(response) {
                // Réponse du serveur
                if (response.success) {
                    alert(response.message); // Afficher un message de succès
                    $("#reviewPopup").fadeOut(); // Fermer la fenêtre modale
                } else {
                    alert(response.message); // Afficher un message d'erreur
                }
            },
            error: function(xhr, status, error) {
                console.error("Erreur AJAX : " + status, error);
            }
        });
    });
});
