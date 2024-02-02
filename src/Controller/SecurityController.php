<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Psr\Log\LoggerInterface;

class SecurityController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/connexion", name="app_security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Check if a login attempt was made (and if there is an error)
        if ($lastUsername && $error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }


    /**
     * @Route("/logout", name="app_security_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);

            $user->setPassword($hashedPassword);
            $userRepository->add($user, true);

            $this->addFlash('success', 'Inscription réussie, connectez-vous.');

            return $this->redirectToRoute('app_home');
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            // add error message if the form is submitted but not valid
            $this->addFlash('error', 'Une erreur s\'est produite lors de l\'inscription. Veuillez vérifier vos informations.');

            // Log les erreurs détaillées pour une enquête ultérieure si nécessaire
            $this->logger->error('Registration error: ' . $form->getErrors(true, false));
        }

        return $this->renderForm('security/register.html.twig', [
            'form' => $form,
        ]);
    }
}
