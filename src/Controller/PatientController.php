<?php

namespace App\Controller;

use App\Entity\RDV;
use App\Form\RdvType;
use App\Repository\RDVRepository;
use App\Repository\StatutRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    #[Route('/prendre-rdv', name: 'prendre_rdv')]
    public function index(Request $request, UserRepository $userRepository, StatutRepository $statutRepository, EntityManagerInterface $em): Response
    {
        $rdv = new RDV();
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $rdv->setPatient($userRepository->getCorresp($this->getUser()));
            $rdv->setStatut($statutRepository->find(2));
            $rdv->setDuree(30);
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('mes_rdv');
        }
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/mes-rdv', name: 'mes_rdv')]
    public function rdvs(UserRepository $userRepository): Response
    {
        return $this->render('patient/mes_rdv.html.twig', [
            'rdvs' => $userRepository->getCorresp($this->getUser())->getRdvs()
        ]);
    }

    #[Route('/rdv{id}')]
    public function rdv($id, RDVRepository $rr, EntityManagerInterface $em, Request $request): Response
    {
        $rdv = $rr->find($id);
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('mes_rdv');
        }
        return $this->render('patient/index.html.twig', [
            'form' => $form
        ]);
    }
}
