<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use SendGrid\Mail\Mail;

// Récupérer la clé API depuis les variables d’environnement
$sendgridApiKey = getenv('SENDGRID_API_KEY') ?: $_ENV['SENDGRID_API_KEY'];

// Récupération et sanitisation des données du formulaire
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Échapper les caractères spéciaux pour éviter les problèmes d'encodage
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

// Convertir en UTF-8
$email = mb_convert_encoding($email, 'UTF-8');
$subject = mb_convert_encoding($subject, 'UTF-8');
$description = mb_convert_encoding($description, 'UTF-8');

$mail = new Mail();
$mail->setFrom('info.arcadiazoo@gmail.com', 'Contact client');
$mail->setSubject($subject);
$mail->addTo('info.arcadiazoo@gmail.com', 'Arcadia Zoo');

$emailContent = "Vous avez reçu un nouveau message de la part d'un client.<br><br>";
$emailContent .= "Email: $email<br>";
$emailContent .= "Description:<br>$description<br>";

// Ajoute le contenu au format HTML
$mail->addContent('text/html', $emailContent);

// Envoi de l'e-mail
$sendgrid = new \SendGrid($sendgridApiKey);

try {
    $response = $sendgrid->send($mail);
    echo "Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.";
} catch (Exception $e) {
    echo 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage();
}
?>
