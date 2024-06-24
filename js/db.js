// db.js

const mysql = require('mysql');

// Configuration de la connexion à MySQL
const connection = mysql.createConnection({
  host: 'localhost', // ou l'adresse de votre serveur MySQL
  user: 'root', // votre nom d'utilisateur MySQL
  password: '', // votre mot de passe MySQL
  database: 'zoo' // le nom de votre base de données MySQL
});

// Connexion à MySQL
connection.connect((err) => {
  if (err) {
    console.error('Erreur de connexion à MySQL : ' + err.stack);
    return;
  }
  console.log('Connecté à MySQL avec l\'ID ' + connection.threadId);
});

module.exports = connection;
