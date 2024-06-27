const express = require("express");
const bodyParser = require("body-parser");
const connection = require("./js/db"); // Assurez-vous que le chemin vers votre fichier de connexion à la base de données est correct
const cors = require("cors");
const path = require("path");

const app = express();
const port = 3005;

// Middleware pour permettre CORS (autoriser toutes les origines)
const corsOptions = {
  origin: "http://127.0.0.1:5500", // Remplacez cette URL par celle de votre application
  methods: ["GET", "POST"],
};

app.use(cors(corsOptions));

// Middleware pour parser les requêtes POST
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Middleware pour servir les fichiers statiques depuis le répertoire racine
app.use(express.static(path.join(__dirname, "/")));

// Route pour gérer la connexion
app.post("/login", (req, res) => {
  const { username, password } = req.body;

  // Vérifier les informations de connexion dans la base de données
  const query =
    "SELECT * FROM Utilisateur WHERE Username = ? AND MotDePasse = ?";
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
      const userType = results[0].TypeUtilisateur;
      if (["administrateur", "veterinaire", "employe"].includes(userType)) {
        res.json({ success: true, userType });
      } else {
        res.status(403).json({
          success: false,
          message:
            "Seul une personne de type administrateur, vétérinaire ou employé peut se connecter.",
        });
      }
    } else {
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

// Routes pour les espaces des utilisateurs
app.get("/admin", (req, res) => {
  res.sendFile(path.join(__dirname, "espace-connexion", "admin.html"));
});

app.get("/employe", (req, res) => {
  res.sendFile(path.join(__dirname, "espace-connexion", "employe.html"));
});

app.get("/veterinaire", (req, res) => {
  res.sendFile(path.join(__dirname, "espace-connexion", "veterinaire.html"));
});

// Route pour gérer les services par les employés
app.post("/employe/services", (req, res) => {
  const { serviceName, serviceDescription } = req.body;

  const query = "INSERT INTO services (name, description) VALUES (?, ?)";
  connection.query(query, [serviceName, serviceDescription], (err, results) => {
    if (err) {
      console.error("Erreur lors de l'ajout du service : " + err.stack);
      res.status(500).json({
        success: false,
        message: "Erreur lors de l'ajout du service",
      });
      return;
    }
    res.json({
      success: true,
      message: "Service ajouté avec succès",
    });
  });
});

// Route pour gérer l'ajout de nourriture par les employés
app.post("/employe/alimentation", (req, res) => {
  const { animalName, date, time, food, quantity } = req.body;

  // Rechercher l'ID de l'animal par son nom
  const queryGetAnimalId = "SELECT animalId FROM animaux WHERE especeAnimal = ?";
  connection.query(queryGetAnimalId, [animalName], (err, results) => {
    if (err) {
      console.error("Erreur lors de la recherche de l'ID de l'animal : " + err.stack);
      res.status(500).json({
        success: false,
        message: "Erreur lors de la recherche de l'ID de l'animal",
      });
      return;
    }

    if (results.length === 0) {
      res.status(404).json({
        success: false,
        message: "L'animal spécifié n'a pas été trouvé",
      });
      return;
    }

    const animalId = results[0].animalId;

    // Insérer l'alimentation avec l'ID de l'animal récupéré
    const queryInsertAlimentation =
      "INSERT INTO alimentation (especeAnimal, date, heure, nourriture, quantité, animalId) VALUES (?, ?, ?, ?, ?, ?)";
    connection.query(
      queryInsertAlimentation,
      [animalName, date, time, food, quantity, animalId],
      (err, results) => {
        if (err) {
          console.error(
            "Erreur lors de l'ajout de l'alimentation : " + err.stack
          );
          res.status(500).json({
            success: false,
            message: "Erreur lors de l'ajout de l'alimentation",
          });
          return;
        }
        res.json({
          success: true,
          message: "Alimentation ajoutée avec succès",
        });
      }
    );
  });
});

// Route pour gérer les avis par les employés
app.post("/employe/avis", (req, res) => {
  const { avisId, valide } = req.body;

  const query = "UPDATE avis SET valide = ? WHERE id = ?";
  connection.query(query, [valide, avisId], (err, results) => {
    if (err) {
      console.error("Erreur lors de la mise à jour de l'avis : " + err.stack);
      res.status(500).json({
        success: false,
        message: "Erreur lors de la mise à jour de l'avis",
      });
      return;
    }
    res.json({
      success: true,
      message: "Avis mis à jour avec succès",
    });
  });
});

// Route pour gérer l'ajout d'un nouvel animal par les employés
app.post("/employe/nouvel-animal", (req, res) => {
  const { especeAnimal, habitat, regimeAlimentaire } = req.body;

  const query =
    "INSERT INTO animaux (especeAnimal, habitat, regimeAlimentaire) VALUES (?, ?, ?)";
  connection.query(
    query,
    [especeAnimal, habitat, regimeAlimentaire],
    (err, results) => {
      if (err) {
        console.error(
          "Erreur lors de l'ajout du nouvel animal : " + err.stack
        );
        res.status(500).json({
          success: false,
          message: "Erreur lors de l'ajout du nouvel animal",
        });
        return;
      }
      res.json({
        success: true,
        message: "Nouvel animal ajouté avec succès",
      });
    }
  );
});

// Écouter le port défini
app.listen(port, () => {
  console.log(`Serveur en écoute sur le port ${port}`);
});
