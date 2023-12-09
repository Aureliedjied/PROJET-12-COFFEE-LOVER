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
}
