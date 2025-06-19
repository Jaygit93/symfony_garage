<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Service;
use App\Form\AvisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Récupérer tous les services
        $services = $entityManager->getRepository(Service::class)->findAll();

        // Récupérer tous les avis approuvés
        $avisRepository = $entityManager->getRepository(Avis::class);
        $avis_list = $avisRepository->findBy(['approuveAvis' => true]);

        // Gestion de l'ajout d'avis si l'utilisateur est connecté
        $user = $this->getUser();
        $existingAvis = null;

        if ($user) {
            // Vérifier si l'utilisateur a déjà soumis un avis
            $existingAvis = $avisRepository->findOneBy(['utilisateur' => $user]);

            if (!$existingAvis) {
                $avis = new Avis();
                $avisForm = $this->createForm(AvisType::class, $avis);
                $avisForm->handleRequest($request);

                if ($avisForm->isSubmitted() && $avisForm->isValid()) {
                    // Soumettre un nouvel avis non approuvé
                    $avis->setUtilisateur($user);
                    $avis->setDatePublicationAvis(new \DateTime());
                    $entityManager->persist($avis);
                    $entityManager->flush();

                    // Redirection vers la section des avis après l'envoi
                    return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
                }
            }
        }

        // Renvoyer la vue avec les services, les avis, et le formulaire ou messages spécifiques
        return $this->render('home/index.html.twig', [
            'title' => 'Bienvenue sur notre site',
            'services' => $services,
            'avis_list' => $avis_list,
            'avis_form' => isset($avisForm) ? $avisForm->createView() : null,
            'existing_avis' => $existingAvis,
        ]);
    }
}