# NewApp – Interface Web Laravel pour ERPNext (via API)

## 📌 Description

**NewApp** est une application web développée en **Laravel** (MVC) permettant d'interagir avec un système **ERPNext** existant (ExistingApp) **via API REST**.  
Elle utilise des appels sécurisés à l'ERP via `sid` (session ID) et fonctionne en complète autonomie côté interface.

Le projet a pour but de fournir une interface conviviale et intuitive aux utilisateurs finaux sans modifier le cœur d’ERPNext, en facilitant l'import, la visualisation, la gestion des salaires et les statistiques.

---

## 🔗 Architecture

 
- 🔐 Authentification via `sid` obtenu à partir du login ERPNext
- 📡 Communication **uniquement unidirectionnelle** (NewApp → ExistingApp)

---

## ✨ Fonctionnalités de NewApp

### 🔐 Authentification
- Connexion via identifiants ERPNext (utilisation du `sid`)
- Sécurisation des requêtes API avec token de session

### 📥 Import de données
- Import de fichiers **CSV** (employés, éléments de salaire, etc.)
- Validation stricte du format, notamment des **dates**
- Affichage des erreurs en cas de données incorrectes

### 👥 Gestion des employés
- Liste des employés avec **filtres de recherche dynamiques**
- Fiche employé avec l’historique de ses salaires par mois
- Affichage des fiches de paie mensuelles
- **Export PDF** propre et soigné des fiches de paie

### 📊 Statistiques
- Tableau mensuel des salaires avec :
  - Total global
  - Détails par **élément de salaire**
  - **Filtre par année**
- Au clic sur un total mensuel : vue détaillée par employé
- Graphique d’évolution :
  - Total des salaires par mois
  - Détail des principaux éléments de salaire

---

## 🧰 Technologies utilisées

- **Frontend / API Client** : Laravel, Bootstrap, HTML, CSS, JavaScript
- **Backend distant** : ERPNext (Frappe Framework)
- **Communication** : API REST avec session ID (`sid`)
- **Outils de test** : Postman (pour tester les endpoints API)

---

## 🛠️ Installation

1. Cloner ce dépôt :
```bash
git clone https://github.com/tonpseudo/NewApp.git
cd NewApp
    Installer les dépendances Laravel :

composer install
npm install && npm run dev


    Lancer l'application :

php artisan serve
