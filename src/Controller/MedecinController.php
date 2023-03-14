<?php

namespace App\Controller;

use App\Entity\Indisponibilite;
use App\Form\IndisponibiliteType;
use App\Repository\IndisponibiliteRepository;
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

    #[Route('/medecin/rdv', name: 'rdv_medecin')]
    public function rdvMedecin(UserRepository $userRepository): Response
    {
        return $this->render('medecin/index.html.twig', [
            'rdvs' => $userRepository->getCorresp($this->getUser())->getRdvs()
        ]);
    }

    #[Route('/medecin/rdv{id}')]
    public function rdv($id, RDVRepository $rr, EntityManagerInterface $em, Request $request, StatutRepository $statutRepository): Response
    {
        $rdv = $rr->find($id);
        $form = $this->createFormBuilder($rdv)
            ->add('date', DateTimeType::class, [
                'years' => range(date('Y'), date('Y')+1)
            ])
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

    #[Route('/medecin/indisponibilites', name: 'indispo')]
    public function indispo(UserRepository $userRepository)
    {
        return $this->render('medecin/indispo.html.twig', [
            'indispos' => $userRepository->getCorresp($this->getUser())->getIndisponibilites()
        ]);
    }

    #[Route('/medecin/ajouter-indisponibilite', name: 'new_indispo')]
    public function newIndispo(Request $request, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $indispo = new Indisponibilite();
        $form = $this->createForm(IndisponibiliteType::class, $indispo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $indispo->setMedecin($userRepository->getCorresp($this->getUser()));
            $em->persist($indispo);
            $em->flush();
            return $this->redirectToRoute('indispo');
        }
        return $this->render('medecin/newIndispo.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/medecin/indisponibilite/{id}')]
    public function modifIndispo($id, Request $request, UserRepository $userRepository, EntityManagerInterface $em, IndisponibiliteRepository $ir): Response
    {
        $indispo = $ir->find($id);
        if($userRepository->getCorresp($this->getUser())==$indispo->getMedecin()){
            $form = $this->createForm(IndisponibiliteType::class, $indispo);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $indispo->setMedecin($userRepository->getCorresp($this->getUser()));
                $em->persist($indispo);
                $em->flush();
                return $this->redirectToRoute('indispo');
            }
            return $this->render('medecin/newIndispo.html.twig', [
                'form' => $form
            ]);
        }
        return $this->redirectToRoute('indispo');
    }

    #[Route('/medecin/delete-indispo/{id}')]
    public function deleteIndispo($id, UserRepository $userRepository, IndisponibiliteRepository $ir, EntityManagerInterface $em): Response
    {
        $indispo=$ir->find($id);
        if($userRepository->getCorresp($this->getUser())==$indispo->getMedecin()){
            $em->remove($indispo);
            $em->flush();
        }
        return $this->redirectToRoute('indispo');
    }
}
