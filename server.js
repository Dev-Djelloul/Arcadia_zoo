const express = require("express");
const bodyParser = require("body-parser");
const connection = require("./js/db");
const cors = require("cors");
const path = require("path"); // Module pour manipuler les chemins de fichier

const app = express();
const port = 3005;

// Middleware pour permettre CORS (autoriser toutes les origines)
app.use(cors());

// Middleware pour parser les requêtes POST
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Middleware pour servir les fichiers statiques depuis le répertoire racine
app.use(express.static(path.join(__dirname, '/')));

// Route pour gérer la connexion
app.post("/login", (req, res) => {
  const { username, password } = req.body;

  // Vérifier les informations de connexion dans la base de données
  const query =
    "SELECT * FROM utilisateur WHERE Username = ? AND MotDePasse = ?";
  connection.query(query, [username, password], (err, results) => {
    if (err) {
      console.error("Erreur lors de la requête de connexion : " + err.stack);
      res.status(500).json({
        success: false,
        message: "Erreur lors de la requête de connexion",
      });
      return;
    }

    if (results.length > 0) {
      const user = results[0];
      const userType = user.TypeUtilisateur;

      // Vérifier si l'utilisateur est de type autorisé (Administrateur, Veterinaire, Employe)
      if (userType === 'administrateur' || userType === 'vétérinaire' || userType === 'employé') {
        // Connexion réussie pour les utilisateurs autorisés
        const authMessage = `${user.Username} vous êtes connecté à votre espace ${userType} !`;
        res.json({ success: true, message: authMessage });
      } else {
        // Utilisateur non autorisé à se connecter
        res.status(403).json({
          success: false,
          message: "Seul une personne de type administrateur, vétérinaire ou employé peut se connecter.",
        });
      }
    } else {
      // Aucun utilisateur trouvé avec les informations d'identification fournies
      res.status(401).json({
        success: false,
        message: "Nom d'utilisateur ou mot de passe incorrect",
      });
    }
  });
});

// Route pour la racine de l'application
app.get("/", (req, res) => {
  res.send("Bienvenue sur Arcadia Zoo");
});

// Middleware pour gérer les erreurs 404 (route non trouvée)
app.use((req, res, next) => {
  res.status(404).send("Page introuvable");
});

// Démarrer le serveur
app.listen(port, () => {
  console.log(`Serveur démarré sur http://localhost:${port}`);
});
