<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

 // Contrôleur CRUD pour l'entité `Avis` dans EasyAdmin.
class AvisCrudController extends AbstractCrudController
{
    
     // Retourne le nom de classe de l'entité liée à ce CRUD.
    public static function getEntityFqcn(): string
    {
        return Avis::class;
    }

     // Configure les champs à afficher dans le CRUD (index, formulaire, etc.).
    public function configureFields(string $pageName): iterable
    {
        return [
            // Affiche l'ID de l'avis, masqué dans les formulaires de création/édition.
            IdField::new('id')->hideOnForm(),
            // Champ pour le nom de l'avis.
            TextField::new('nomAvis', 'Nom de l\'avis')->hideOnForm(),
            // Champ pour le commentaire de l'avis.
            TextareaField::new('commentaireAvis', 'Commentaire')->hideOnForm(),
            // Champ pour la note donnée (1 à 5).
            IntegerField::new('noteAvis', 'Note')->hideOnForm(),
            // Champ pour indiquer si l'avis est approuvé ou non.
            BooleanField::new('approuveAvis', 'Approuvé'),
            // Champ pour la date de publication de l'avis.
            DateTimeField::new('datePublicationAvis', 'Date de publication')->hideOnForm(),
            // Champ pour afficher l'utilisateur associé, masqué dans les formulaires.
            AssociationField::new('utilisateur', 'Utilisateur')->hideOnForm(),
        ];
    }
}
