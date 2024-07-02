<?php
$servername = "localhost";
$username = "root";
$password = "";  
$dbname = "zoo";
$socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";  

// Crée une connexion
$conn = new mysqli($servername, $username, $password, $dbname, null, $socket);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM Utilisateur WHERE Username = ? AND MotDePasse = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userType'] = $row['TypeUtilisateur'];
        $_SESSION['username'] = $row['Username'];

        if ($row['TypeUtilisateur'] == 'administrateur') {
            header("Location: /espace-connexion_utilisateurs/users/admin.html");
        } elseif ($row['TypeUtilisateur'] == 'veterinaire') {
            header("Location: /espace-connexion_utilisateurs/users/veterinaire.html");
        } elseif ($row['TypeUtilisateur'] == 'employe') {
            header("Location: /espace-connexion_utilisateurs/users/employe.html");
        } else {
            header("Location: /espace-connexion_utilisateurs/users/visiteur.html");
        }
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

$conn->close();
?>
