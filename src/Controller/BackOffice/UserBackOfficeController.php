<?php

namespace App\Controller\BackOffice;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserBackOfficeController extends AbstractController
{
    /**
     * @Route("/back-office/utilisateurs", name="app_back_users")
     */
    public function list(UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            
            return $this->render('bundles/TwigBundle/Exception/error403-backoffice.html.twig');
        }
        return $this->render('back-office/user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    

    /**
     * @Route("/back-office/utilisateur/edit/{id}", name="app_back_users_edit")
     */
    public function edit($id, Request $request, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_back_users');
        }

        return $this->render('back-office/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/back-office/utilisateur/delete/{id}", name="app_back_users_delete")
     */
    public function delete($id, UserRepository $userRepository)
    {

        $user = $userRepository->find($id);

        // On récupère les articles liés à l'utilisateur
        $articles = $user->getArticles();

        // Attribuer un autre utilisateur aux articles existants
        $otherUser = $userRepository->find(1);

        foreach ($articles as $article) {
            $article->setUser($otherUser);
        }
        $userRepository->remove($user, true);
        
        return $this->redirectToRoute("app_back_users");
    }

    /**
     * @Route("/back-office/utilisateur/add", name="app_back_users_add")
     */
    // public function create(Request $request, UserRepository $userRepository)
    // {
    //     $user = new User();

    //     $form = $this->createForm(UserFormType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $userRepository->add($user, true);

    //         return $this->redirectToRoute('app_back_users');
    //     }

    //     return $this->render('back-office/user/add.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }
}
