<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\Assistant;
use App\Form\AssistantType;
use App\Form\MedecinType;
use App\Form\PatientType;
use App\Form\PatientUserType;
use App\Form\RegistrationFormType;
use App\Form\AssistantRegistrationFormType;
use App\Form\MedecinRegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('registration/register.html.twig');
    }

    #[Route('/register/Patient', name: 'app_register_patient')]
    public function registerPatient(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(["ROLE_PATIENT"]);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
        }

        return $this->render('registration/registerPatient.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    
    #[Route('/register/Medecin', name: 'app_register_medecin')]
    public function registerMedecin(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(MedecinRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(["ROLE_MEDECIN"]);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
        }

        return $this->render('registration/registerMedecin.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    
    #[Route('/register/Assistant', name: 'app_register_assistant')]
    public function registerAssistant(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(AssistantRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(["ROLE_ASSISTANT"]);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

        }

        return $this->render('registration/registerAssistant.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/create/patient', name: 'app_register_create_patient')]
    public function registerCreatePatient(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_register_patient');
        }

        return $this->render('registration/registerCreatePatient.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/create/medecin', name: 'app_register_create_medecin')]
    public function registerCreateMedecin(Request $request, EntityManagerInterface $entityManager): Response
    {
        $medecin = new Medecin();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($medecin);
            $entityManager->flush();

            return $this->redirectToRoute('app_register_medecin');
        }

        return $this->render('registration/registerCreateMedecin.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/create/assistant', name: 'app_register_create_assistant')]
    public function registerCreateAssistant(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assistant = new Assistant();
        $form = $this->createForm(AssistantType::class, $assistant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assistant);
            $entityManager->flush();

            return $this->redirectToRoute('app_register_assistant');
        }

        return $this->render('registration/registerCreateAssistant.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/PatientUser', name: 'app_register_patient_user')]
    public function registerPatientUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(PatientUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(["ROLE_ASSISTANT"]);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

        }

        return $this->render('registration/registerPatientUser.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
