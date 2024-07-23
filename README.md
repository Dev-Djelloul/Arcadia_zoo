___________________________________________________________________________________________


## Table des matières

Ce document README.md couvre les étapes essentielles pour installer, configurer, et lancer l'application. 


- [Présentation du projet]
- [Prérequis d'installation]
- [Cloner le dépôt]
- [Configuration]
- [Lancer l'application]
- [Utilisation]
- [Contribution]
- [Dépannage]


___________________________________________________________________________________________



## Présentation du projet

Ce projet consiste à développer une application web pour un zoo, permettant aux visiteurs de visualiser les animaux, leurs habitats et les services offerts. 
L'application fournira également un espace pour l'administrateur, les vétérinaires et le personnel du zoo pour saisir et visualiser des informations internes sur les animaux au parc.



## Prérequis d'installation

Avant de commencer, assurez-vous d'avoir installé les éléments suivants :

- [XAMPP](https://www.apachefriends.org/index.html) (ou tout autre serveur web local)
- [Composer](https://getcomposer.org/) (pour la gestion des dépendances PHP)
- [Git](https://git-scm.com/) (pour le clonage du dépôt)
- Un compte [Heroku](https://www.heroku.com/) (pour la base de données MySQL)
- [MongoDB](https://www.mongodb.com/) (pour la gestion des consultations des animaux)


## Cloner le dépôt

Pour accéder au projet en local, clonez ce dépôt Git sur votre machine :

"git clone https://github.com/Dev-Djelloul/Arcadia_zoo.git"


**Puis ouvrez-le fichier dans votre éditeur de code Visual Studio Code** 

Ouvrir un nouveau terminal à la racine du projet : 

'cd votre/chemin/Arcadia_zoo'


**Puis lancez votre serveur web local**

- Lancez le serveur PHP avec la ligne de commande suivante : 'php -S 127.0.0.1:4000' depuis le terminal de votre éditeur de code

- Accédez ensuite à l'application via votre navigateur web à l'adresse choisie : http://localhost:4000


**Configuration**

Configuration de la base de données MySQL :

- Créez une nouvelle base de données "zoo" et importer le fichier MySQL "zoo.sql" fourni dans le dépôt Git  

- Mettez à jour les informations de connexion à la base de données dans le code PHP au besoin 

Configuration de MongoDB : 

- Assurez-vous que MongoDB est installé et en cours d'exécution.

- Mettez à jour les informations de connexion à MongoDB dans le code PHP au besoin


**Utilisation de l'application web**

Les espaces personnels de connexion des utilisateurs sont accessibles avec les identifiants suivants : 

Administrateur
• Email: admin@arcadiazoo.com
• Mot de passe: arcadia

Vétérinaire
• Email: veterinaire@arcadiazoo.com
• Mot de passe: arcadia

Employé
• Email: employe@arcadiazoo.com
• Mot de passe: arcadia

Email du zoo : info.arcadiazoo@gmail.com
mot de passe : arcadia


## Visiteurs :

Les visiteurs peuvent naviguer sur le site pour voir les différentes sections :

- Accueil
- Nos Services
- Nos Habitats
- Contact

## Administrateur et Personnel :

Les administrateurs et le personnel peuvent accéder à l'interface de gestion pour :

- Ajouter/Modifier/Supprimer des informations sur les animaux et leurs habitats ainsi que les services du parc
- Consulter les comptes-rendus vétérinaires
- Suivre les consultations des animaux via MongoDB
 


**Contribution**

Les contributions sont les bienvenues !

Pour contribuer :

- Fork ce dépôt.
- Créez une branche pour votre fonctionnalité (git checkout -b feature/ma-nouvelle-fonctionnalité).
- Commitez vos changements (git commit -am 'Ajoute une nouvelle fonctionnalité').
- Poussez votre branche (git push origin feature/ma-nouvelle-fonctionnalité).
- Créez une Pull Request.


**Dépannage**

- Erreur de connexion à la base de données : Vérifiez que les informations de connexion dans config.php sont correctes.

- Problèmes avec Composer : Assurez-vous que Composer est correctement installé et que toutes les dépendances sont à jour.

- Problèmes avec MongoDB : Assurez-vous que le service MongoDB est en cours d'exécution et que les informations de connexion sont correctes.




