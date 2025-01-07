<?php

namespace App\Controller;

use App\Entity\Developper;
use App\Entity\Entreprise;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, redirection vers une autre page
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Récupère les erreurs de connexion, s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier email utilisé
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route('/dev/register', name: 'app_dev_register')]
public function registerDev(
    Request $request,
    UserPasswordHasherInterface $passwordHasher,
    EntityManagerInterface $entityManager
): Response {
    $user = new User();
    $user->setRoles(['ROLE_DEV']); // Attribuer le rôle spécifique

    $form = $this->createForm(RegistrationFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && !$form->isValid()) {
        $errors = $form->getErrors(true, false);
        foreach ($errors as $error) {
            dump((string) $error);
        }
        exit; // This will print errors directly to the screen. You can use it to inspect errors in the profiler.
    }

    if ($form->isSubmitted() && $form->isValid()) {
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $form->get('plainPassword')->getData()
        );
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        // Create and persist the Developper entity
        $developper = new Developper();
        $developper->setUserDevelopper($user);
        $developper->setFirstName('DefaultFirstName');
        $developper->setLastName('DefaultLastName');

        $entityManager->persist($developper);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
    }

    return $this->render('registration/dev_register.html.twig', [
        'registrationForm' => $form->createView(),
    ]);
}

#[Route('/company/register', name: 'app_company_register')]
    public function registerCompany(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $user->setRoles(['ROLE_COMPANY']); // Attribuer le rôle spécifique
    
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $user->setPassword($hashedPassword);
    
            $entityManager->persist($user);
            $entityManager->flush();

            //pour que le user soit un company
            $entreprise1 = new Entreprise();
            $entreprise1->setUserEntreprise($user);
            $entreprise1->setName('DefaultCoName');


            $entityManager->persist($entreprise1);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_login');

        }



    
        return $this->render('registration/company_register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
