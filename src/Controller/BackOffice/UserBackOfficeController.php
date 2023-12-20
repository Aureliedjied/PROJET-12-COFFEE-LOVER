<?php

namespace App\Controller\BackOffice;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\EventSubscriber\PaginationSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back-office")
 */
class UserBackOfficeController extends AbstractController
{   private $paginationSubscriber;
    private $paginator;

    public function __construct(
        PaginationSubscriber $paginationSubscriber,
        PaginatorInterface $paginator
    ) {
        $this->paginationSubscriber = $paginationSubscriber;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/utilisateurs", name="app_back_users")
     */
    public function list(UserRepository $userRepository, Request $request): Response
    {   
     
        if (!$this->isGranted('ROLE_ADMIN')) {
            
        return $this->render('bundles/TwigBundle/Exception/error403-backoffice.html.twig');
        }
        $user = $userRepository->findAll();
        $pagination = $this->paginator->paginate(
            $user,
            // Start to page number 1 :
            $request->query->getInt('page', 1), 
            // 10 per page :
            10 
        );
        return $this->render('back-office/user/list.html.twig', [
           'users'=>$pagination
        ]);
    }

    

    /**
     * @Route("/utilisateur/modifier/{id}", name="app_back_users_edit")
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
     * @Route("/utilisateur/delete/{id}", name="app_back_users_delete")
     */
    public function delete($id, UserRepository $userRepository)
    {

        $user = $userRepository->find($id);

        // We retrieve the items linked to the user
        $articles = $user->getArticles();

        // Assign another user to existing articles
        $otherUser = $userRepository->find(1);

        foreach ($articles as $article) {
            $article->setUser($otherUser);
        }
        $userRepository->remove($user, true);
        
        return $this->redirectToRoute("app_back_users");
    }

    /**
     * @Route("/utilisateur/add", name="app_back_users_add")
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
