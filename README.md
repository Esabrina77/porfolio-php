# Portfolio Manager

Une application web de gestion de portfolio permettant aux utilisateurs de présenter leurs projets et compétences.

## 🚀 Fonctionnalités

### Utilisateurs
- Inscription et connexion sécurisée
- Gestion des projets personnels (CRUD)
- Recherche de projets
- Pagination des résultats
- Gestion des compétences

### Administrateurs
- Gestion des utilisateurs
- Gestion globale des projets
- Gestion des compétences globales.
- Tableau de bord administratif

## 📋 Prérequis

- PHP 8.0 ou supérieur
- MySQL/MariaDB 10.4 ou supérieur
- Serveur web (Apache/Nginx)

## 🔧 Installation

1. Cloner le repository
```bash
git clone https://github.com/Esabrina77/portfolio-php.git
cd portfolio-php
```

2. Configurer la base de données
```bash
mysql -u root -p < database.sql
```

3. Configurer le .env
```env
DB_HOST=localhost
DB_NAME=projetb2
DB_USER=projetb2
DB_PASS=password
DB_PORT=3306
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

- Protection CSRF
- Validation des données
- Sessions sécurisées
- Protection XSS

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

Sabrina ELOUNDOU
- GitHub: [@Esabrina77](https://github.com/Esabrina77)
- Email: sabrina.eloundou@ynov.com
