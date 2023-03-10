<?php

namespace App\Controller;

use App\Form\RdvType;
use App\Repository\RDVRepository;
use App\Repository\StatutRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedecinController extends AbstractController
{
    #[Route('/medecin')]
    public function index(): Response
    {
        return $this->redirect('index');
    }

    #[Route('/rdv', name: 'rdv_medecin')]
    public function rdvMedecin(UserRepository $userRepository): Response
    {
        return $this->render('medecin/index.html.twig', [
            'rdvs' => $userRepository->getCorresp($this->getUser())->getRdvs()
        ]);
    }

    #[Route('/rdv_{id}')]
    public function rdv($id, RDVRepository $rr, EntityManagerInterface $em, Request $request, StatutRepository $statutRepository): Response
    {
        $rdv = $rr->find($id);
        $form = $this->createFormBuilder($rdv)
            ->add('date', DateTimeType::class)
            ->add('duree', IntegerType::class)
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $rdv->setStatut($statutRepository->find(4));
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('rdv_medecin');
        }
        return $this->render('medecin/modif_rdv.html.twig', [
            'form' => $form
        ]);
    }
}
