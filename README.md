Introduction:

Ce projet est une application de gestion de voitures construite avec le framework Symfony 7.1. 
L'objectif est de fournir une interface utilisateur intuitive pour les administrateurs et les employés afin de gérer les entités telles que les voitures, les avis et les témoignages.
Le déploiement est géré via Docker pour simplifier l'intégration et le déploiement continu.

Pré-requis:

- PHP 8.2 ou supérieur
- Composer 2.x
- Docker et Docker Compose
- Node.js et npm (pour la gestion des assets)
- Extension PHP intl pour la gestion des dates et heures
- Installation et Déploiement avec Docker


1. Cloner le Répertoire
bash
Copier le code
git clone https://github.com/Jaygit93/jay_garage.git
cd projet-voitures


2. Configuration des Variables d'Environnement
Créez un fichier .env.local à la racine du projet et configurez les variables nécessaires :


Copier le code
DATABASE_URL=mysql://root:password@mysql:3306/symfony

APP_ENV=dev

APP_SECRET=some_secret

FIREBASE_API_KEY=your_firebase_api_key


3. Construction et Démarrage des Conteneurs
Lancez la commande suivante pour démarrer les conteneurs Docker :
bash
Copier le code
docker-compose up --build


4. Installation des Dépendances
Installez les dépendances PHP et JavaScript :

bash
Copier le code
docker-compose exec php composer install
docker-compose exec node npm install


5. Initialisation de la Base de Données
Mettez à jour le schéma de la base de données :

bash
Copier le code
docker-compose exec php php bin/console doctrine:migrations:migrate


6. Accéder à l'Application
L'application est maintenant accessible à l'adresse http://localhost:8000.

Architecture du Projet
L'architecture du projet est basée sur les principes MVC (Modèle-Vue-Contrôleur) de Symfony, avec une organisation spécifique pour les dashboards et les rôles utilisateur.

arduino
Copier le code
├── src
│   ├── Controller
│   │   ├── Admin
│   │   ├── Employee
│   ├── Entity
│   ├── Repository
│   ├── Security
│   ├── Service
│   ├── Form
├── config
├── public
├── templates
└── migrations
Les Entités
Utilisateur
Propriétés :

id: Identifiant unique
email: Email de l'utilisateur
password: Mot de passe (haché)
roles: Rôles de l'utilisateur (ROLE_ADMIN, ROLE_EMPLOYE)
roleUtilisateur: Type d'utilisateur (admin ou employe)
voitures: Relation avec les voitures possédées
Voiture
Propriétés :

id: Identifiant unique
marqueVoiture: Marque de la voiture
modeleVoiture: Modèle de la voiture
prixVoiture: Prix de la voiture
anneeVoiture: Année de fabrication
kilometrageVoiture: Kilométrage
imageVoiture: URL de l'image de la voiture
equipementsVoiture: Liste des équipements
caracteristiquesVoiture: Liste des caractéristiques techniques
boiteVoiture: Type de boîte (manuelle, automatique)
utilisateur: Relation avec l'utilisateur (propriétaire)


Avis
Propriétés :

id: Identifiant unique
titre: Titre de l'avis
contenu: Contenu de l'avis
note: Note sur 5
createdAt: Date de création


Témoignage
Propriétés :

id: Identifiant unique
nom: Nom de l'auteur
contenu: Contenu du témoignage
createdAt: Date de création
Service
Propriétés :

id: Identifiant unique
nom: Nom du service
description: Description du service
prix: Prix du service


Les Contrôleurs

Contrôleurs Admin
Les contrôleurs pour les administrateurs sont situés dans src/Controller/Admin. Ils gèrent toutes les entités du système, avec un accès complet.

DashboardController: Gestion du tableau de bord principal
UserCrudController: Gestion des utilisateurs
VoitureCrudController: Gestion des voitures
AvisCrudController: Gestion des avis
TemoignageCrudController: Gestion des témoignages
Contrôleurs Employé
Les contrôleurs pour les employés sont situés dans src/Controller/Employee. Ils ont un accès restreint, uniquement aux entités qui leur sont attribuées.

EmployeeDashboardController: Tableau de bord des employés
VoitureCrudController: Gestion des voitures liées à l'employé connecté
AvisCrudController: Gestion des avis
TemoignageCrudController: Gestion des témoignages
Dashboard avec EasyAdmin
Dashboard Administrateur
Les administrateurs ont accès à toutes les entités du système. Ils peuvent ajouter, modifier ou supprimer des utilisateurs, voitures, avis, témoignages, et services.

php
Copier le code
public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
    yield MenuItem::linkToCrud('Voitures', 'fas fa-car', Voiture::class);
    yield MenuItem::linkToCrud('Avis', 'fas fa-comment', Avis::class);
    yield MenuItem::linkToCrud('Témoignages', 'fas fa-comments', Temoignage::class);
}
Dashboard Employé
Les employés ont accès uniquement aux entités qui leur sont attribuées. Par exemple, ils peuvent gérer les voitures dont ils sont propriétaires et consulter les avis et témoignages.

php
Copier le code
public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('Avis', 'fas fa-comment', Avis::class);
    yield MenuItem::linkToCrud('Témoignages', 'fas fa-comments', Temoignage::class);
}


Utilisation de Firebase pour le Formulaire de Contact
Le projet utilise l'API Firebase pour envoyer les messages du formulaire de contact. Le bundle kreait/firebase-bundle est utilisé pour interagir avec l'API Firebase.

Configuration
Installez le bundle Firebase :

bash
Copier le code
composer require symfony/firebase-bundle
Configurez Firebase dans le fichier config/packages/firebase.yaml :

yaml
Copier le code
firebase:
    credentials: '%kernel.project_dir%/config/firebase_credentials.json'
    database:
        url: 'https://your-database-url.firebaseio.com'
Utilisation dans un contrôleur :

php
Copier le code
namespace App\Controller;

use Kreait\Firebase\Database;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

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


Tests
Les tests unitaires et fonctionnels sont essentiels pour garantir la stabilité du projet.

Tests Unitaires :

bash
Copier le code
php bin/phpunit --testsuite=unit


Tests Fonctionnels :

bash
Copier le code
php bin/phpunit --testsuite=functional
Tests avec Behat :

bash
Copier le code
vendor/bin/behat
Contribution
Les contributions sont les bienvenues ! Pour contribuer :

Forkez le projet.
Créez une branche pour votre fonctionnalité (git checkout -b ma-fonctionnalité).
Commitez vos modifications (git commit -am 'Ajoute une nouvelle fonctionnalité').
Poussez vers la branche (git push origin ma-fonctionnalité).
Créez une Pull Request.
Support
Pour toute question ou problème, veuillez ouvrir une issue sur GitHub.

Licence
Ce projet est sous licence MIT. Vous êtes libre de l'utiliser et de le modifier selon vos besoins.
