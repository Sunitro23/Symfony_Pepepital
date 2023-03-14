<?php

namespace App\Controller;

use App\Repository\RDVRepository;
use App\Repository\StatutRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function valider($id, UserRepository $userRepository, EntityManagerInterface $em, RDVRepository $rdvRep, StatutRepository $statutRepository): Response
    {
        $rdv = $rdvRep->find($id);
        if ($this->getUser()->getType() == 1) {
            if ($userRepository->getCorresp($this->getUser())->getId() == $rdv->getPatient()) {
                $rdv->setStatut($statutRepository->find(1));
                $em->persist($rdv);
                $em->flush();
            }
        } else {
            if ($this->getUser()->getType() == 2) {
                if ($userRepository->getCorresp($this->getUser())->getId() == $rdv->getMedecin()) {
                    $rdv->setStatut($statutRepository->find(1));
                    $em->persist($rdv);
                    $em->flush();
                }
            } else {
                if ($this->getUser()->getType() == 3) {
                    if ($userRepository->getCorresp($this->getUser()) == $rdv->getMedecin()->getAssistant()) {
                        $rdv->setStatut($statutRepository->find(1));
                        $em->persist($rdv);
                        $em->flush();
                    }
                }
            }
        }
        return $this->redirectToRoute('rdv_medecin');
    }
}
