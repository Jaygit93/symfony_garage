<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(EntityManagerInterface $em, Request $request)
    {
        // Récupérer tous les avis approuvés
        $avisRepository = $em->getRepository(Avis::class);
        $avis_list = $avisRepository->findBy(['approuveAvis' => true]);

        // Gérer le formulaire d'ajout d'avis si l'utilisateur est connecté
        if ($this->getUser()) {
            $avis = new Avis();
            $avisForm = $this->createForm(AvisType::class, $avis);
            $avisForm->handleRequest($request);

            // Vérifier si l'utilisateur a déjà soumis un avis
            $user = $this->getUser();
            $existingAvis = $avisRepository->findOneBy(['utilisateur' => $user]);

            if ($existingAvis) {
                $this->addFlash('danger', 'Vous avez déjà soumis un avis.');
            } elseif ($avisForm->isSubmitted() && $avisForm->isValid()) {
                // Sauvegarder un nouvel avis non approuvé
                $avis->setUtilisateur($user);
                $avis->setDatePublicationAvis(new \DateTime());
                $em->persist($avis);
                $em->flush();

                $this->addFlash('success', 'Votre avis a été soumis et sera examiné avant publication.');
            }
        }

        // Renvoyer la vue avec les avis et le formulaire
        return $this->render('home/index.html.twig', [
            'avis_list' => $avis_list, // On passe la variable 'avis_list' ici
            'avis_form' => isset($avisForm) ? $avisForm->createView() : null,
        ]);
    }
}