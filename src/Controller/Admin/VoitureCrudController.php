<?php

namespace App\Controller\Admin;

use App\Entity\Voiture;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class VoitureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Voiture::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('marqueVoiture')->hideOnForm(),
            TextField::new('modeleVoiture')->hideOnForm(),
            NumberField::new('prixVoiture')->hideOnForm(),
            NumberField::new('anneeVoiture')->hideOnForm(),
            NumberField::new('kilometrageVoiture')->hideOnForm(),
            ImageField::new('imageVoiture', 'Image')->hideOnForm()
                ->setBasePath('img_voitures') 
                ->setUploadDir('public/img_voitures')
                ->setRequired(false),
            TextareaField::new('equipementsVoiture')->hideOnForm(),
            TextareaField::new('caracteristiquesVoiture')->hideOnForm(),
            ChoiceField::new('boiteVoiture')->hideOnForm()
                ->setChoices([
                    'Manuelle' => 'manuelle',
                    'Automatique' => 'automatique',
                ]),
            AssociationField::new('utilisateur')->hideOnForm()
                ->setFormTypeOption('by_reference', false)
                ->setLabel('Propriétaire'),
        ];
    }
}