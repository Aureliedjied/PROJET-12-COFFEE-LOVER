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

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // get the login error if there is one
        if ($error = $authenticationUtils->getLastAuthenticationError()) {
            $this->addFlash('error', $error->getMessage());
        }
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

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

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
            // l'objet user
            $user,
            // le mot de passer à hasher
            $plaintextPassword
        );
        // je set le password
        $user->setPassword($hashedPassword);
        
        $userRepository->add($user, true);
        return $this->redirectToRoute('app_home');
    }

    return $this->renderForm('security/register.html.twig', [
        'form' => $form,
    ]);
}
}