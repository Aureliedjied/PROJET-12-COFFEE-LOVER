<?php

namespace App\Controller\BackOffice;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserBackOfficeController extends AbstractController
{
    /**
     * @Route("/back-office/utilisateurs", name="app_back_users")
     */
    public function list(UserRepository $userRepository): Response
    {
       
        return $this->render('back-office/user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * delete user
     *
     * @Route("/back-office/utilisateur/delete/{id}", name="app_back_utilsateur_delete")
     */
    public function delete($id, UserRepository $userRepository)
    {
        // On recupere l'user
        $user = $userRepository->find($id);
        
        $userRepository->remove($user, $flush = true);
        
        return $this->redirectToRoute("app_back_users");
    }
}
