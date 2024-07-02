<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupére les données du formulaire
    $subject = $_POST["subject"];
    $description = $_POST["description"];
    $email = $_POST["email"];  // Adresse email saisie par l'utilisateur
    
    // Adresse email du destinataire
    $to = "info.arcadiazoo@gmail.com";  
    
    // Construction du corps de l'email
    $message = "Description :\n" . $description . "\n\n";
    $message .= "Email de l'expéditeur : " . $email . "\n";

    // Commande pour envoyer l'e-mail via msmtp
    $command = 'echo -e "From: ' . addslashes($email) . '\nTo: ' . $to . '\nSubject: ' . addslashes($subject) . '\n\n' . addslashes($message) . '" | msmtp --debug --from=info.arcadiazoo@gmail.com -t ' . $to;

    // Commande exécutée pour envoyer l'e-mail
    exec($command, $output, $return_var);

    // Vérification si l'e-mail a été envoyé avec succès
    if ($return_var == 0) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Votre message a été envoyé avec succès !"), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Une erreur est survenue lors de l'envoi du message."), JSON_UNESCAPED_UNICODE);
        // Affiche le retour de la commande pour le débogage
        echo "Command output: " . implode("\n", $output);
    }
} else {
    // Si la méthode HTTP n'est pas POST, renvoyer une erreur 405 (Méthode non autorisée)
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Méthode non autorisée"), JSON_UNESCAPED_UNICODE);
}
?>
