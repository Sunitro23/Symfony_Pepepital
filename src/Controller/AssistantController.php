<?php

namespace App\Controller;

use App\Repository\RDVRepository;
use App\Repository\StatutRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssistantController extends AbstractController
{
    #[Route('/assistant', name: 'app_assistant')]
    public function index(): Response
    {
        return $this->redirectToRoute('index');
    }

    #[Route('/assistant/rdv', name: 'rdv_assistant')]
    public function rdv(UserRepository $userRepository): Response
    {
        $rdv = $userRepository->getCorresp($this->getUser())->getMedecin()->getRdvs();
        return $this->render('/assistant/rdv.html.twig', [
            'rdvs' => $rdv
        ]);
    }

    #[Route('/assistant/rdv{id}')]
    public function modifRdv($id, RDVRepository $rr, EntityManagerInterface $em, Request $request, StatutRepository $statutRepository): Response
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
}
