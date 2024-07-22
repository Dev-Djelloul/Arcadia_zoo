<?php
// Vérification de l'extension MongoDB
if (extension_loaded('mongodb')) {
    echo "L'extension MongoDB est installée et activée.";
} else {
    echo "L'extension MongoDB n'est pas installée ou activée.";
}
?>
