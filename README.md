# Municipal Library (Symfony)

Application d’exemple pour la gestion d’une **bibliothèque municipale** (EFREI). Projet pédagogique orienté **sécurisation Web** avec Symfony.

---

## ✨ Aperçu
- Authentification par formulaire (`form_login`) + *remember-me* (48h)
- Rôles : `ROLE_USER` (consultation/CRUD livres), `ROLE_ADMIN` (espace admin)
- CRUD complet sur l’entité **Book** (titre, résumé, année de publication, auteur/ajouteur)
- **CSP** (Content-Security-Policy) ajoutée globalement
- **CSRF** activé (Form + formulaires manuels)
- **Pages d’erreur** personnalisées (401/403/404/405)
- **Mode sombre / clair** via cookie `myapp_dark_mode`

---

## 🧱 Stack & prérequis
- **PHP** ≥ 8.2
- **Composer** ≥ 2.5
- **Symfony CLI** (recommandé)
- **SQLite** (par défaut)
- Navigateur moderne (DevTools pour vérifs sécurité)

---

## ⚙️ Installation
```bash
# 1) Cloner le dépôt
git clone https://github.com/El-Profesor/EFREI-Municipal-Library.git
cd EFREI-Municipal-Library

# 2) Dépendances
composer install

# 3) Variables d’environnement
cp .env .env.local
# Ajuster si besoin (APP_ENV, APP_SECRET, DATABASE_URL, etc.)

# 4) Base de données (SQLite par défaut)
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate -n || php bin/console doctrine:schema:update --force

# 5) Lancer le serveur de dev
symfony serve -d   # ou: php -S localhost:8000 -t public
```

---

## 👤 Comptes & rôles (exemple)
> Générer des utilisateurs via un *fixture* ou un formulaire d’inscription si disponible.

```bash
php bin/console security:hash-password "MonSuperMot2Passe!"
# Créer un utilisateur dans la BDD (SQL/fixtures) et lui assigner ROLE_USER/ROLE_ADMIN
```

---

## 📚 Fonctionnalités principales
- **Livres** : lister, voir, créer, éditer, supprimer
- **Utilisateurs** : (si module admin activé) gestion par un admin
- **Thème** :
  - `GET /theme/dark` → pose `myapp_dark_mode=true`
  - `GET /theme/light` → pose `myapp_dark_mode=false`

---

## 🔐 Sécurisation (OWASP Top 10:2021)
### 1) Contrôle d’accès
- `config/packages/security.yaml` :
  - `access_control` → `/book` réservé à `ROLE_USER`, `/admin` à `ROLE_ADMIN`
  - *remember_me* activé `lifetime: 172800` (48h)

### 2) CSRF
- Activé par défaut pour les formulaires Symfony
- Formulaires manuels : champ `_token` via `{{ csrf_token('delete' ~ book.id) }}`

### 3) CSP (Content-Security-Policy)
- `App\EventSubscriber\CspSubscriber` ajoute l’en-tête :
  - `default-src 'self'; script-src 'self' https://trusted.cdn.com`
- Vérifier dans DevTools → Network → Headers

### 4) Pages d’erreur
- `templates/bundles/TwigBundle/Exception/` : 401/403/404/405 personnalisées

### 5) Validation
- Contraintes dans `Entity\User` et `Entity\Book` (longueur, not blank, etc.)
- Validation manuelle possible dans les contrôleurs

### 6) Dépendances
- `composer audit` pour détecter les vulnérabilités (coller la sortie dans le RENDU)

---

## 🖼️ Captures attendues (rendu)
- **Cookie remember-me (<48h)**
- **Cookie `myapp_dark_mode`**
- **En-tête `Content-Security-Policy`**
- **Champ `_token`** dans le DOM

Placez-les dans `./screens/` et référencez-les dans votre Rendu.md.

---

## 🧭 Routes utiles
```bash
php bin/console debug:router
```
- `/login`, `/logout`
- `/book`, `/book/{id}` (show), `/book/{id}/edit`
- `/admin` (si existant)
- `/theme/dark`, `/theme/light`

---

## 🧪 Commandes utiles
```bash
# Lancer en dev
symfony serve -d

# Cache / logs
php bin/console cache:clear
# Logs: var/log/dev.log / prod.log

# BDD
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force

# Audit sécurité
composer audit
composer outdated --direct
```

---

## 📦 Structure (extrait)
```
├─ config/
│  └─ packages/security.yaml
├─ src/
│  ├─ Controller/
│  │  └─ ThemeController.php
│  ├─ Entity/ (User.php, Book.php)
│  └─ EventSubscriber/
│     └─ CspSubscriber.php
├─ templates/
│  ├─ base.html.twig
│  ├─ book/ (index/show/_form/_delete_form)
│  └─ bundles/TwigBundle/Exception/ (error401/403/404/405)
└─ public/
```

---

## 🚀 Déploiement (pistes rapides)
- Configurer `APP_ENV=prod`, `APP_DEBUG=0`, clé `APP_SECRET`
- Mettre à jour la BDD (`migrations`)
- Servir `public/` derrière Nginx/Apache
- S’assurer que les **en-têtes CSP** sont en place en prod

---

## 📝 Licence
Projet pédagogique – usage éducatif.

---

## 👤 Auteur
EFREI – Module Sécurisation (Symfony) • Encadrement : N. Brousse • Étudiant : _[votre nom]_

