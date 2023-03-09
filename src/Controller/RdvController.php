<?php

namespace App\Controller;

use App\Entity\RDV;
use App\Form\ModifRDVType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Routing\Annotation\Route;

class RdvController extends AbstractController
{
    #[Route('/rdv', name: 'app_rdv')]
    public function getListeRDV(ManagerRegistry $doctrine,Request $request): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MEDECIN')){
        $medecin= $user->getMedecin();
        } else{
            $medecin = $user->getAssistant()->getMedecin();
        }

        $rdv = $medecin->getRDVs();

        # $lesRDV = $rdv->findByDate($date,$order,$medecin);
        return $this->render('rdv/index.html.twig', [
            'lesRDV' => $rdv,
        ]);
    }
    #[Route('/rdv/{id}', name: 'modif_rdv')]
    public function modifRDV(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $em = $doctrine->getManager();
        $unRDV= $doctrine->getRepository(RDV::class)->find($id);

        $form = $this->createForm(ModifRDVType::class, $unRDV);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($unRDV);
            $em->flush();
            return $this->redirectToRoute('app_rdv');
        }
        return $this->render('rdv/modif_rdv.html.twig', array(
            'form'=>$form->createView(),
            'unRDV'=> $unRDV,
        ));
    }
    #[Route('/email', name: 'mail')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $transport = Transport::fromDsn('native://default');
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from('basile.mercado@gmail.com')
            ->to('lael.vander@gmail.com')
            ->subject('Test')
            ->html('<p> Ceci est un test il ne faut pas paniquer !</p>');
        $mailer->send($email);

        return $this->render('principal/index.html.twig');
    }

    #[Route('/', name: 'app_principal')]
    public function principal(): Response
    {
        return $this->render('principal/index.html.twig');
    }
}
