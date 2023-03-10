<?php

namespace App\Controller;

use App\Repository\RDVRepository;
use App\Repository\StatutRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/valider/{id}')]
    public function valider($id, UserRepository $userRepository, RDVRepository $rdvRep, StatutRepository $statutRepository): Response
    {
        $rdv = $rdvRep->find($id);
        var_dump($rdv);
        // return $this->redirectToRoute('rdv_medecin');
    }
}
