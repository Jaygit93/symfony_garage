<?php

namespace App\Controller\Employee;

use App\Entity\Temoignage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

/**
 * Contrôleur CRUD pour l'entité `Temoignage` dans EasyAdmin.
 */
class TemoignageCrudController extends AbstractCrudController
{
    /**
     * Retourne le nom de classe de l'entité liée à ce CRUD.
     */
    public static function getEntityFqcn(): string
    {
        return Temoignage::class;
    }

    /**
     * Configure les champs à afficher dans le CRUD (index, formulaire, etc.).
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            // ID unique du témoignage, masqué dans les formulaires.
            IdField::new('id')->hideOnForm(),
            // Champ pour le nom associé au témoignage.
            TextField::new('nomTemoignage', 'Nom du témoignage')->hideOnForm(),
            // Champ pour le commentaire associé au témoignage.
            TextareaField::new('commentaireTemoignage', 'Commentaire')->hideOnForm(),
            // Champ pour la note donnée (1 à 5).
            IntegerField::new('noteTemoignage', 'Note')->hideOnForm(),
            // Champ indiquant si le témoignage est approuvé ou non.
            BooleanField::new('approuveTemoignage', 'Approuvé'),
            // Champ pour la date de publication du témoignage.
            DateTimeField::new('datePublicationTemoignage', 'Date de publication')->hideOnForm(),
            // Champ pour afficher l'utilisateur associé au témoignage (non modifiable).
            AssociationField::new('utilisateur', 'Utilisateur')->hideOnForm(),
            // Champ pour afficher la voiture associée au témoignage (non modifiable).
            AssociationField::new('voiture', 'Voiture')->hideOnForm(),
        ];
    }
}
