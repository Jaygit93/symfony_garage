
# 🚗 Application de Gestion de Voitures - Symfony 7.1

Ce projet est une application web construite avec Symfony 7.1. Elle permet aux administrateurs et employés de gérer des entités comme les voitures, les avis et les témoignages, avec une interface intuitive. Le déploiement se fait via Docker pour une intégration et une livraison continues simplifiées.

## 🛠️ Prérequis

- PHP 8.2 ou supérieur
- Composer 2.x
- Docker & Docker Compose
- Node.js & npm
- Extension PHP `intl`

## 🚀 Installation & Déploiement avec Docker

### 1. Cloner le Répertoire

```bash
git clone <url-du-repo>
cd projet-voitures
```

### 2. Configuration des Variables d'Environnement

Créer un fichier `.env.local` à la racine et ajouter :

```env
DATABASE_URL=mysql://user:password@mysql:3306/symfony
APP_ENV=dev
APP_SECRET=some_secret
FIREBASE_API_KEY=your_firebase_api_key
```

### 3. Construction & Démarrage des Conteneurs

```bash
docker-compose up --build
```

### 4. Installation des Dépendances

```bash
docker-compose exec php composer install
docker-compose exec node npm install
```

### 5. Initialisation de la Base de Données

```bash
docker-compose exec php php bin/console doctrine:migrations:migrate
```

### 6. Accès à l'Application

Ouvrez [http://localhost:8000](http://localhost:8000) dans votre navigateur.

## 🏗️ Architecture du Projet

```txt
├── src
│   ├── Controller
│   │   ├── Admin
│   │   └── Employee
│   ├── Entity
│   ├── Repository
│   ├── Security
│   ├── Service
│   └── Form
├── config
├── public
├── templates
└── migrations
```

## 📦 Entités Principales

### Utilisateur

- `id`, `email`, `password`, `roles`, `roleUtilisateur`, `voitures`

### Voiture

- `id`, `marqueVoiture`, `modeleVoiture`, `prixVoiture`, `anneeVoiture`, `kilometrageVoiture`, `imageVoiture`, `equipementsVoiture`, `caracteristiquesVoiture`, `boiteVoiture`, `utilisateur`

### Avis

- `id`, `titre`, `contenu`, `note`, `createdAt`

### Témoignage

- `id`, `nom`, `contenu`, `createdAt`

### Service

- `id`, `nom`, `description`, `prix`

## 🎮 Contrôleurs

### Admin (`src/Controller/Admin`)

- `DashboardController`
- `UserCrudController`
- `VoitureCrudController`
- `AvisCrudController`
- `TemoignageCrudController`

### Employé (`src/Controller/Employee`)

- `EmployeeDashboardController`
- `VoitureCrudController`
- `AvisCrudController`
- `TemoignageCrudController`

## 📊 Dashboards avec EasyAdmin

### Administrateur

```php
public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
    yield MenuItem::linkToCrud('Voitures', 'fas fa-car', Voiture::class);
    yield MenuItem::linkToCrud('Avis', 'fas fa-comment', Avis::class);
    yield MenuItem::linkToCrud('Témoignages', 'fas fa-comments', Temoignage::class);
}
```

### Employé

```php
public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('Avis', 'fas fa-comment', Avis::class);
    yield MenuItem::linkToCrud('Témoignages', 'fas fa-comments', Temoignage::class);
}
```

## 📩 Formulaire de Contact avec Firebase

### Installation

```bash
composer require symfony/firebase-bundle
```

### Configuration `config/packages/firebase.yaml`

```yaml
firebase:
    credentials: '%kernel.project_dir%/config/firebase_credentials.json'
    database:
        url: 'https://your-database-url.firebaseio.com'
```

### Exemple de Contrôleur

```php
class ContactController extends AbstractController
{
    public function __construct(private Database $database) {}

    public function contactForm(Request $request): Response
    {
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'message' => $request->get('message'),
        ];

        $this->database->getReference('contacts')->push($data);

        return $this->json(['status' => 'Message envoyé avec succès !']);
    }
}
```

## ✅ Tests

### Tests Unitaires

```bash
php bin/phpunit --testsuite=unit
```

### Tests Fonctionnels

```bash
php bin/phpunit --testsuite=functional
```

### Tests Behat

```bash
vendor/bin/behat
```

## 🤝 Contribution

1. Forkez le repo
2. Créez votre branche (`git checkout -b feature/ma-fonctionnalite`)
3. Commitez (`git commit -am 'Ajoute une fonctionnalité'`)
4. Poussez (`git push origin feature/ma-fonctionnalite`)
5. Créez une Pull Request

## 🆘 Support

Ouvrez une issue GitHub en cas de problème.

## 📄 Licence

Ce projet est sous licence MIT.
