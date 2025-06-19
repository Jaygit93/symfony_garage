<?php

namespace App\Controller;

use App\Repository\HorairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    public function horairesOuverture(HorairesRepository $horairesRepository): Response
    {
        // Récupérer tous les horaires
        $horaires = $horairesRepository->findAll();

        return $this->render('footer.html.twig', [
            'horaires' => $horaires,
        ]);
    }
}
