<?php

// src/Controller/PolitiqueController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolitiqueController extends AbstractController
{
     #[Route("/politique", name:"politique_confidentialite")]
    public function index(): Response
    {
        return $this->render('politique/politique_confidentialite.html.twig');
    }
}
