# Portfolio Manager

Une application web de gestion de portfolio permettant aux utilisateurs de présenter leurs projets et compétences.

## 🚀 Fonctionnalités

### Utilisateurs
- Inscription et connexion sécurisée
- Gestion du profil utilisateur
- Upload d'avatar
- Gestion des projets personnels
- Gestion des compétences

### Administrateurs
- Gestion des utilisateurs
- Gestion globale des projets
- Gestion des compétences disponibles
- Tableau de bord administratif

## 📋 Prérequis

- PHP 8.0 ou supérieur
- MySQL/MariaDB 10.4 ou supérieur
- Serveur web (Apache/Nginx)
- Composer (pour les dépendances)

## 🔧 Installation

1. Cloner le repository
```bash
git clone https://github.com/votre-username/portfolio-manager.git
cd portfolio-manager
```

2. Configurer la base de données
```bash
mysql -u root -p < database/database.sql
```

3. Configurer les variables d'environnement
```php
DB_HOST = 'localhost'
DB_PORT = 3306
DB_NAME = 'projetb2'
DB_USER = 'projetb2'
DB_PASS = 'password'
```

4. Démarrer le serveur de développement
```bash
php -S localhost:8000
```

## 👥 Comptes de test

### Administrateur
- Email: admin@example.com
- Mot de passe: password

### Utilisateur
- Email: user@example.com
- Mot de passe: password

## 🏗️ Structure du projet

```plaintext
portfolio-manager/
├── config/             # Configuration de l'application
├── controllers/        # Contrôleurs
├── models/            # Modèles
├── views/             # Vues
├── public/            # Fichiers publics (CSS, JS, images)
├── includes/          # Fichiers inclus
└── database/          # Fichiers de base de données
```

## 🔒 Sécurité

- Protection contre les injections SQL
- Protection XSS
- Hachage des mots de passe
- Validation des données
- Sessions sécurisées

## 📱 Interface utilisateur

- Design responsive
- Interface intuitive
- Thème moderne
- Compatibilité mobile

## 🛠️ Technologies utilisées

- PHP 8
- MySQL/MariaDB
- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- PDO

## 📝 License

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 👨‍💻 Auteur

[Votre Nom]
- GitHub: [@votre-username](https://github.com/Esabrina77)
- Email: sabrina.eloundou@ynov.com
