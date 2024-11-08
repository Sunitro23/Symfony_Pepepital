<?php

namespace App\Controller;

use App\Entity\RDV;
use App\Form\RdvType;
use App\Repository\IndisponibiliteRepository;
use App\Repository\MedecinRepository;
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
    #[Route('/patient/prendre-rdv', name: 'prendre_rdv')]
    public function index(Request $request, UserRepository $userRepository, StatutRepository $statutRepository, EntityManagerInterface $em, IndisponibiliteRepository $indisponibiliteRepository): Response
    {
        $rdv = new RDV();
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);
        $error = null;
        if($form->isSubmitted() && $form->isValid()){
            $rdv->setPatient($userRepository->getCorresp($this->getUser()));
            $rdv->setStatut($statutRepository->find(2));
            $rdv->setDuree(30);
            if($indisponibiliteRepository->isDispo($rdv->getDate())){
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('mes_rdv');
            } else {
                $error = 'Le médecin est indisponible sur cette date';
            }
        }
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
            'form' => $form->createView(),
            'error' => $error,
            'indispos' => $indisponibiliteRepository->findAll()
        ]);
    }

    #[Route('/patient/mes-rdv', name: 'mes_rdv')]
    public function rdvs(UserRepository $userRepository): Response
    {
        return $this->render('patient/mes_rdv.html.twig', [
            'rdvs' => $userRepository->getCorresp($this->getUser())->getRdvs()
        ]);
    }

    #[Route('/patient/rdv{id}')]
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
