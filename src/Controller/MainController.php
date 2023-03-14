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
        if ($this->getUser()->getType()->getId() == 1 && $rdv->getStatut()->getId()==4 && $userRepository->getCorresp($this->getUser()) == $rdv->getPatient()) {
            $rdv->setStatut($statutRepository->find(1));
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('mes_rdv');
        } else {
            if ($this->getUser()->getType()->getId() == 2 && $rdv->getStatut()->getId()==2 && $userRepository->getCorresp($this->getUser()) == $rdv->getMedecin()) {
                $rdv->setStatut($statutRepository->find(1));
                $em->persist($rdv);
                $em->flush();
                return $this->redirectToRoute('rdv_medecin');
            } else {
                if ($this->getUser()->getType()->getId() == 3 && $rdv->getStatut()->getId()==2 && $userRepository->getCorresp($this->getUser()) == $rdv->getMedecin()->getAssistant()) {
                    $rdv->setStatut($statutRepository->find(1));
                    $em->persist($rdv);
                    $em->flush();
                    return $this->redirectToRoute('rdv_assistant');
                }
            }
        }
        return $this->redirectToRoute('index');
    }
}
