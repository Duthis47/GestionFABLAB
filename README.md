# 🛠️ GestionFABLAB

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP->=7.4-777bb4.svg)[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]

**GestionFABLAB** est une solution web complète pour piloter et administrer un laboratoire de fabrication numérique (FabLab).[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)] Elle permet de gérer les membres, les réservations de machines et le suivi des projets.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]

---

## 🚀 Fonctionnalités

- **👥 Gestion des Membres :** Inscription, suivi des adhésions et niveaux d'accès.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
- **📅 Réservation de Machines :** Planning interactif pour les imprimantes 3D, découpeuses laser, etc.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
- **📦 Inventaire :** Suivi des consommables (filaments, bois, composants électroniques).
- **🛡️ Administration :** Panneau de configuration pour gérer les droits et les paramètres de la base de données.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
- **🔒 Sécurité :** Hachage des mots de passe via BCRYPT.

---

## 🛠️ Installation

### Prérequis
- Un serveur web (Apache/Nginx)[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
- PHP 7.4 ou supérieur[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
- MySQL / MariaDB[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
- [Composer](https://getcomposer.org/)[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]

### Étapes d'installation

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/Duthis47/GestionFABLAB.git
   cd GestionFABLAB
   ```[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]

2. **Installer les dépendances PHP :**
   ```bash
   composer install
   ```[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]

3. **Configuration :**
   - Renommez les fichiers de configuration (si nécessaire) et éditez `config.bdd.php` avec vos identifiants de base de données.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
   - Importez le fichier SQL (si présent) dans votre base de données.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]

4. **Lancer le projet :**
   Pointez votre serveur web vers le dossier `public_html`.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]

---

## 📂 Structure du projet

- `public_html/` : Point d'entrée de l'application (Index, CSS, JS).[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
- `config.bdd.php` : Configuration de la connexion à la base de données.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)] 
- `config.admin.php` : Paramètres spécifiques à l'administration.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
- `mdpBCRYPT.php` : Utilitaire de gestion de la sécurité des comptes.[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]

---

## ✉️ Contact

Duthis47 - [Profil GitHub](https://github.com/Duthis47)
Projet : [GestionFABLAB](https://github.com/Duthis47/GestionFABLAB)
```[[1](https://www.google.com/url?sa=E&q=https%3A%2F%2Fgithub.com%2FDuthis47%2FGestionFABLAB)]
