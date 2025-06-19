<?php

namespace App\Controller;

use App\Form\TemoignageType;
use App\Entity\Temoignage;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class VoitureController extends AbstractController
{
    #[Route('/voitures', name: 'voitures_liste')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération des filtres et du paramètre de pagination
        $marque = $request->query->get('marque');
        $prix = $request->query->get('prix');
        $annee = $request->query->get('annee');
        $boite = $request->query->get('boite');
        $page = max(1, (int)$request->query->get('page', 1)); // Page par défaut : 1
        $limit = 12; // Nombre initial de voitures à afficher

        // Construire la requête pour filtrer les voitures
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('v')
            ->from(Voiture::class, 'v');

        if ($marque) {
            $queryBuilder->andWhere('v.marqueVoiture = :marque')
                         ->setParameter('marque', $marque);
        }
        if ($prix) {
            switch ($prix) {
                case '10000-15000':
                    $queryBuilder->andWhere('v.prixVoiture BETWEEN 10000 AND 15000');
                    break;
                case '15001-20000':
                    $queryBuilder->andWhere('v.prixVoiture BETWEEN 15001 AND 20000');
                    break;
                case '20001-25000':
                    $queryBuilder->andWhere('v.prixVoiture BETWEEN 20001 AND 25000');
                    break;
                case '25001-30000':
                    $queryBuilder->andWhere('v.prixVoiture BETWEEN 25001 AND 30000');
                    break;
                case '30001-35000':
                    $queryBuilder->andWhere('v.prixVoiture BETWEEN 30001 AND 35000');
                    break;
            }
        }
        if ($annee) {
            $queryBuilder->andWhere('v.anneeVoiture = :annee')
                         ->setParameter('annee', $annee);
        }
        if ($boite) {
            $queryBuilder->andWhere('v.boiteVoiture = :boite')
                         ->setParameter('boite', $boite);
        }

        // Ajouter la pagination
        $queryBuilder->setFirstResult(($page - 1) * $limit)
                     ->setMaxResults($limit);

        $voitures = $queryBuilder->getQuery()->getResult();

        // Rendre la vue avec les voitures filtrées
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
            'page' => $page,
        ]);
    }

    #[Route('/voitures/load-more', name: 'voitures_load_more')]
    public function loadMore(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $offset = (int)$request->query->get('offset', 0);
        $limit = 8;

        // Construire la requête avec offset et limite
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('v')
            ->from(Voiture::class, 'v')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $voitures = $queryBuilder->getQuery()->getResult();

        $html = $this->renderView('voiture/_voiture_cards.html.twig', ['voitures' => $voitures]);

        return new JsonResponse(['html' => $html]);
    }

    #[Route('/voitures/{id}', name: 'voiture_details')]
    public function details(Voiture $voiture, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();
        
        // Initialiser la variable form à null par défaut
        $temoignageForm = null;
    
        if ($utilisateur) {
            // Vérifier si l'utilisateur a déjà commenté cette voiture
            $existingTemoignage = $entityManager->getRepository(Temoignage::class)->findOneBy([
                'voiture' => $voiture,
                'utilisateur' => $utilisateur,
            ]);
    
            // Si pas de commentaire existant, on permet d'en ajouter un
            if (!$existingTemoignage) {
                $temoignage = new Temoignage();
                $temoignage->setVoiture($voiture);
                $temoignage->setDatePublicationTemoignage(new \DateTime());
                $temoignage->setUtilisateur($utilisateur);
    
                // Créer le formulaire
                $form = $this->createForm(TemoignageType::class, $temoignage);
                $form->handleRequest($request);
    
                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->persist($temoignage);
                    $entityManager->flush();
    
                    $this->addFlash('success', 'Votre témoignage a été soumis.');
                    return $this->redirectToRoute('voiture_details', ['id' => $voiture->getId()]);
                }
    
                // Assigner le formulaire à la variable
                $temoignageForm = $form->createView();
            }
        }
    
        // Récupérer les témoignages approuvés pour cette voiture
        $temoignages = $entityManager->getRepository(Temoignage::class)->findBy([
            'voiture' => $voiture,
            'approuveTemoignage' => true,
        ]);
    
        return $this->render('voiture/details.html.twig', [
            'voiture' => $voiture,
            'form' => $temoignageForm, // Formulaire uniquement pour les utilisateurs connectés
            'temoignages' => $temoignages,
        ]);
    }
}
