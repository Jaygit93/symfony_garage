<?php

namespace App\Controller\Employee;

use App\Entity\Avis;
use App\Entity\Temoignage;
use App\Entity\Voiture;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/employe', name: 'employe_')]
class EmployeePanelController extends AbstractDashboardController
{
    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();

        // Vérifier que l'utilisateur est bien une instance de User
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('L\'utilisateur n\'est pas une instance de User.');
        }

        // Vérifier que l'utilisateur a le rôle 'employe'
        if ($user->getRoleUtilisateur() !== 'employe') {
            throw new AccessDeniedException('Accès refusé : vous n\'avez pas les permissions nécessaires.');
        }

        // Générer l'URL pour rediriger vers le CRUD des Avis
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(VoitureCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de Bord Employé');
    }

    public function configureMenuItems(): iterable
    {
        // Définir les éléments du menu pour les employés
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Témoignages', 'fas fa-comments', Temoignage::class);
        yield MenuItem::linkToCrud('Voitures', 'fas fa-car', Voiture::class);
    }
}
