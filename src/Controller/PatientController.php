<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PatientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\RDV;
use App\Entity\Statut;
use App\Form\RDVType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]
    public function index(): Response
    {
        $patient = $this->getUser()->getPatient();

        return $this->render('patient/index.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/patient/prendre-rdv', name: 'app_create_rdv')]
    public function prendreRdv(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $statut = $doctrine->getRepository(Statut::class)->find(1);
        $rdv = new RDV();
        $form = $this->createForm(RDVType::class, $rdv);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $rdv->setDate(new \DateTime($request->get('datepicker')));
            $rdv->setHeure(new \DateTime($request->get('timepicker')));
            $rdv->setPatient($this->getUser()->getPatient());
            $rdv->setStatut($statut);
            $rdv->setDuree(15);
            $entityManager->persist($rdv);
            $entityManager->flush();

            return $this->redirectToRoute('app_patient');
        }

        return $this->render('rdv/createRdv.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/patient/rdv', name: 'app_patient_rdv')]
    public function patientRdv(): Response
    {
        $user = $this->getUser();
        $rdv = $user->getPatient()->getRDVs();

        return $this->render('patient/rdv.html.twig', [
            'rdvs' => $rdv,
        ]);
    }


    #[Route('/patient/modif-rdv/{id}', name: 'app_patient_modif_rdv')]
    public function patientModifRdv(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, $id): Response
    {
        $statut = $doctrine->getRepository(Statut::class)->find(1);

        $rdv = $doctrine->getRepository(RDV::class)->find($id);

        $form = $this->createForm(RDVType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $rdv->setDate(new \DateTime($request->get('datepicker')));
            $rdv->setHeure(new \DateTime($request->get('timepicker')));
            $rdv->setPatient($this->getUser()->getPatient());
            $rdv->setStatut($statut);
            $rdv->setDuree(15);

            $entityManager->persist($rdv);
            $entityManager->flush();

            return $this->redirectToRoute('app_patient');
        }

        return $this->render('rdv/createRdv.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/patient/annuler-rdv/{id}', name: 'app_patient_annuler_rdv')]
    public function patientAnnulerRdv(EntityManagerInterface $entityManager, ManagerRegistry $doctrine, $id): Response
    {
        $rdv = $doctrine->getRepository(RDV::class)->find($id);

        $form = $this->createFormBuilder()
            ->add('submit', SubmitType::class, ['label' => 'Annuler le rendez-vous'])
            ->getForm();

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->remove($rdv);
            $entityManager->flush();

            return $this->redirectToRoute('app_patient');
        }

        return $this->render('patient/annuler-rdv.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
