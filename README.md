
# 🛠️ Backend E-commerce – Laravel API

## 📌 Présentation

Ce dépôt contient le **backend** de l'application e-commerce mobile développée dans le cadre de mon stage. L'API backend est construite avec **Laravel**, et elle permet d'interagir avec l'application mobile Flutter. L'API repose sur **JWT** pour l'authentification et utilise **MySQL** pour la gestion des données.

Ce backend fournit une architecture robuste et sécurisée pour un système e-commerce complet, gérant les utilisateurs, les produits, les paniers, les commandes, et plus encore.

---

## 🧰 Technologies & Outils

### 🔧 **Frontend**
- **Flutter** (pour l’application mobile)

### 🖥️ **Backend**
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
- [Laravel 10+](https://laravel.com/) – Framework PHP MVC
- [JWT Auth](https://jwt.io/) – Authentification sécurisée avec JSON Web Tokens
- MySQL – Base de données relationnelle
- Laravel Sanctum (optionnel) – Authentification API token
- CORS – Gestion des requêtes cross-origin
- Laravel Eloquent ORM – Gestion des modèles

### 📦 **Outils supplémentaires**
- **Composer** – Gestionnaire de dépendances pour PHP
- **Postman** – Outil pour tester l’API

---

## 📁 Structure du projet

backend/
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ │ ├── Middleware/
│ ├── Models/
├── database/
│ ├── migrations/
│ ├── seeders/
├── routes/
│ └── api.php
├── .env
└── config/
└── jwt.php


---

## 🚀 Fonctionnalités API

Voici les principales fonctionnalités que ce backend prend en charge :

- 🔐 **Authentification des utilisateurs**
    - Inscription des utilisateurs
    - Connexion via JWT (Token)
    - Récupération du profil utilisateur
    - Mise à jour du profil utilisateur

- 🛒 **Gestion des produits**
    - Affichage des produits (liste et détails)
    - Catégorisation des produits

- 🛍️ **Gestion du panier**
    - Ajouter/supprimer des produits au panier
    - Affichage du contenu du panier

- 📦 **Gestion des commandes**
    - Passer une commande
    - Consulter l'historique des commandes
    - Gérer le statut des commandes

- 📊 **Gestion des rôles et autorisation** (Admin)
    - CRUD pour gérer les produits, les utilisateurs et les commandes
    - Statistiques des ventes

---

