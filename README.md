# TOUCHE PAS AU KLAXON - MVC PHP

Application de covoiturage inter-sites realisee en PHP avec architecture MVC.

## Depot GitHub

Lien du depot : https://github.com/Laupaka2/Beaugendre-Jeremy-Devoir-Mise-en-place-application-MVC-en-PHP.git

## Stack technique

- PHP 8.1+
- MySQL/MariaDB
- Routeur PHP : [`izniburak/router`](https://packagist.org/packages/izniburak/router)
- Bootstrap 5
- Sass (a integrer selon votre workflow front)
- Qualite: PHPStan + PHPUnit

## Prerequis

- PHP 8.1+
- Composer 2+
- MySQL ou MariaDB

## Fonctionnalites implantees

- Page d'accueil publique : trajets futurs avec places disponibles.
- Authentification par email / mot de passe.
- Utilisateur connecte :
  - details trajet en modale,
  - creation de trajet,
  - modification/suppression de ses trajets.
- Administrateur :
  - tableau de bord,
  - liste utilisateurs,
  - liste/creation/modification/suppression agences,
  - liste et suppression trajets.

## Installation

1. Copier l'exemple d'environnement :

   ```bash
   cp .env.example .env
   ```

2. Installer les dependances :

   ```bash
   composer install
   ```

   Si Composer n'est pas installe :
   - macOS (Homebrew): `brew install composer`
   - puis verifier: `composer --version`

3. Configurer l'environnement (`.env`) :

   Variables a verifier dans le fichier `.env` :

   ```env
   APP_ENV=dev
   APP_URL=http://localhost:8000
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_NAME=covoiturage_mvc
   DB_USER=root
   DB_PASSWORD=VOTRE_MOT_DE_PASSE
   ```

4. Creer et alimenter la base :

   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p < database/seed.sql
   ```

5. Lancer le serveur :

   ```bash
   composer serve
   ```

6. Ouvrir : `http://localhost:8000`

## Comptes de test

- **Admin**
  - Email: `alexandre.martin@email.fr`
  - Mot de passe: `password`

- **Utilisateur**
  - Email: `sophie.dubois@email.fr`
  - Mot de passe: `password`

## Scripts utiles

- Tests unitaires :
  ```bash
  composer test
  ```
- Analyse statique :
  ```bash
  composer stan
  ```

## Sass / Bootstrap

Le projet inclut un fichier Sass `assets/scss/app.scss` pour definir la palette via variables Bootstrap.
Tu peux compiler ta feuille CSS personnalisee vers `public/assets/css/app.css` selon ton outillage (npm/dart-sass).

## Modelisation

- MCD : `MCD_Devoir_MVC.png`
- MLD (textuel) : `database/MLD.txt`

## Structure

- `public/` : point d'entree HTTP.
- `src/Controller` : controleurs.
- `src/Repository` : acces donnees.
- `src/Core` : briques communes (auth, rendu, validation).
- `src/View` : vues Bootstrap.
- `database/` : scripts SQL (schema + jeu d'essais).
- `tests/` : tests unitaires.
# Beaugendre-Jeremy-Devoir-Mise-en-place-application-MVC-en-PHP
