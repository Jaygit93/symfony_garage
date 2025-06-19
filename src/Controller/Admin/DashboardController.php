<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Service;
use App\Entity\Avis;
use App\Entity\Horaires;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/admin', name: 'admin_')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('L\'utilisateur n\'est pas une instance de User.');
        }

        if ($user->getRoleUtilisateur() !== 'admin') {
            throw new AccessDeniedException('Accès refusé : vous n\'avez pas les permissions nécessaires.');
        }

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->render('dashboard/dashboard.html.twig');


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de Bord Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-cogs', Service::class);
        yield MenuItem::linkToCrud('Horaires', 'fas fa-clock', Horaires::class);
        yield MenuItem::linkToCrud('Avis', 'fas fa-comment', Avis::class);
    }
}
