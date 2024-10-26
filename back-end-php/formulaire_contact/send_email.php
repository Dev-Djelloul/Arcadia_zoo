<?php
require __DIR__ . '/../../../vendor/autoload.php';

// Assurez-vous que vous avez installé SendGrid via Composer

use SendGrid\Mail\Mail;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST["subject"];
    $description = $_POST["description"];
    $email = $_POST["email"];

    $email = new Mail();
    $email->setFrom("info.arcadiazoo@gmail.com", "Arcadia Zoo");
    $email->setSubject($subject);
    $email->addTo("info.arcadiazoo@gmail.com", "Arcadia Zoo");
    $email->addContent("text/plain", "Description: " . $description . "\n\nEmail de l'expéditeur: " . $email);

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    try {
        $response = $sendgrid->send($email);
        http_response_code($response->statusCode());
        echo json_encode(array("message" => "Votre message a été envoyé avec succès !"));
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Une erreur est survenue lors de l'envoi du message."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée"));
}
