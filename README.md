# 🎬 WatchSide

Bienvenue sur **WatchSide**, la plateforme de location de films intergalactique !
Ce projet Symfony gère la location de films avec une tarification dynamique, des rôles utilisateurs (Admin/Pilote) et un design "Glassmorphism" sombre.

## Installation & Démarrage

Suivez ces étapes pour lancer le projet localement.

### 1. Prérequis
Assurez-vous d'avoir installé :
*   **PHP 8.2+**
*   **Composer**
*   **Symfony CLI**
*   **SQLite** (activé dans php.ini)

### 2. Installation des dépendances
À la racine du projet :
```bash
composer install
```

### 3. Initialisation de la Base de Données
Pour partir sur une base propre avec les données de test (Utilisateurs, Films, Locations) :

Stocké dans le fichier `src/DataFixtures/AppFixtures.php`

```bash
# Réinitialisation complète (Drop + Create + Schema + Fixtures)
APP_ENV=dev php bin/console doctrine:database:drop --force
APP_ENV=dev php bin/console doctrine:database:create
APP_ENV=dev php bin/console doctrine:schema:create
APP_ENV=dev php bin/console doctrine:fixtures:load --no-interaction
```

> **Note :** Cette commande crée 4 utilisateurs, ~20 films de science-fiction, et génère des locations/notes aléatoires.

### 4. Lancer le Serveur
```bash
symfony serve -d
```
Le site sera accessible sur `https://127.0.0.1:8000`.

---

## Identifiants de Test (Fixtures)

Voici les comptes générés pour tester l'application :

| Rôle | Identifiant | Mot de Passe | Description |
| :--- | :--- |:-------------| :--- |
| **ADMIN** | `admin` | `admin`      | Accès complet (Formulaires, Gestion Locations, Suppression) |
| **USER** | `yoda` | `yoda`       | Utilisateur standard (Peut louer, noter, voir son profil) |
| **USER** | `vader` | `vader`      | Utilisateur standard |
| **USER** | `han` | `han`        | Utilisateur standard |

Lors de votre inscription votre mot de passe doit contenir au moins 6 caractères

---

## Règles de Tarification (Pricing)

Le prix des locations est dynamique :
1.  **Prix de base** : Calculé selon l'année de sortie (Ancien = 7€, Récent = 15€).
2.  **Réductions** :
    *   **Semaine de Lancement** (1-7 Fev 2026) : -20%
    *   **Jeudi** : -10%
    *   **Dates Spéciales** (4 Mai, Nouvel An) : -20%

Ils sont configurables dans le fichier `config/pricing.yaml`.
