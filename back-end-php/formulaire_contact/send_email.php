<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use SendGrid\Mail\Mail;
use Dotenv\Dotenv;

// Charger les variables d’environnement depuis .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Récupérer la clé API depuis les variables d’environnement
$sendgridApiKey = $_ENV['SENDGRID_API_KEY'];

// Récupération et sanitisation des données du formulaire
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$mail = new Mail();
$mail->setFrom('info.arcadiazoo@gmail.com', 'Contact client');
$mail->setSubject($subject);
$mail->addTo('info.arcadiazoo@gmail.com', 'Arcadia Zoo');

$emailContent = "Vous avez reçu un nouveau message de la part d'un client.\n\n";
$emailContent .= "Email: $email\n";
$emailContent .= "Description:\n$description\n";

$mail->addContent('text/plain', $emailContent);

$sendgrid = new \SendGrid($sendgridApiKey);

try {
    $response = $sendgrid->send($mail);
    echo "Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.";
} catch (Exception $e) {
    echo 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage();
}

?>
