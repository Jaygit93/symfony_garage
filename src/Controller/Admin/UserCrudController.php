<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomUtilisateur'),
            TextField::new('prenomUtilisateur'),
            TextField::new('emailUtilisateur'),
            

            // Utilisation de ChoiceField pour les rôles
            ChoiceField::new('roleUtilisateur', 'Rôle')
                ->setChoices([
                    'Admin' => 'admin',
                    'Employé' => 'employe',
                    'Client' => 'client',
                ])
                ->allowMultipleChoices(false), // Si vous voulez un seul rôle, sinon mettez true pour plusieurs choix
        ];
    }
}
