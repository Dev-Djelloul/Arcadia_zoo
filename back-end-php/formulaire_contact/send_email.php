<?php
// Enregistrement local des messages pour un mode sans service email.

// Récupération et sanitisation des données du formulaire
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!$email || !$subject || !$description) {
    echo "Merci de renseigner tous les champs du formulaire.";
    exit;
}

$logFile = __DIR__ . '/messages.log';
$timestamp = date('Y-m-d H:i:s');

$entry = "[$timestamp]\n";
$entry .= "Email: $email\n";
$entry .= "Objet: $subject\n";
$entry .= "Message:\n$description\n";
$entry .= str_repeat('-', 40) . "\n";

file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);

header("Location: /public/contact.html?sent=1");
exit;
?>
