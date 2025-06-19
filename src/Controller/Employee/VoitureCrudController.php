<?php

namespace App\Controller\Employee;

use App\Entity\Voiture;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class VoitureCrudController extends AbstractCrudController
{
    private TokenStorageInterface $tokenStorage;
    private EntityManagerInterface $entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Voiture::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('marqueVoiture'),
            TextField::new('modeleVoiture'),
            NumberField::new('prixVoiture'),
            NumberField::new('anneeVoiture'),
            NumberField::new('kilometrageVoiture'),
            ImageField::new('imageVoiture', 'Image')
                ->setBasePath('img_voitures') 
                ->setUploadDir('public/img_voitures')
                ->setRequired(false),
            TextareaField::new('equipementsVoiture'),
            TextareaField::new('caracteristiquesVoiture'),
            ChoiceField::new('boiteVoiture')
                ->setChoices([
                    'Manuelle' => 'manuelle',
                    'Automatique' => 'automatique',
                ]),
        ];
    }

    /**
     * Filtre les voitures en fonction de l'utilisateur connecté.
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $qb = $this->entityManager->getRepository(Voiture::class)
            ->createQueryBuilder('v')
            ->where('v.utilisateur = :utilisateur')
            ->setParameter('utilisateur', $user);

        $orderBy = $searchDto->getSort();
        foreach ($orderBy as $field => $direction) {
            $qb->addOrderBy('v.' . $field, $direction);
        }

        return $qb;
    }

    /**
     * Associe l'utilisateur connecté à la voiture créée.
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Voiture) {
            return;
        }

        // Récupérer l'utilisateur connecté
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User) {
            // Associer l'utilisateur connecté à la voiture
            $entityInstance->setUtilisateur($user);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}