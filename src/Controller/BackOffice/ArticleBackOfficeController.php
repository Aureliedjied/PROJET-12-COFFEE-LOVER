<?php

namespace App\Controller\BackOffice;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class ArticleBackOfficeController extends AbstractController
{
    /**
     * @Route("/back-office/articles", name="app_back_articles")
     */
    public function list(ArticleRepository $articleRepository): Response
    {
       

        return $this->render('back-office/article/list.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * delete article
     *
     * @Route("/back-office/articles/delete/{id}", name="app_back_articles_delete")
     */
    public function delete($id, ArticleRepository $articleRepository)
    {
        //  On recupere l'article
        $article = $articleRepository->find($id);
        
        $articleRepository->remove($article, true);
        
        return $this->redirectToRoute("app_back_articles");
    }

    /**
    * @Route("/back-office/articles/ajouter", name="app_back_articles_add")
    */
    public function create(Request $request, ArticleRepository $articleRepository, Security $security)
    {

        $article = new Article();
        // Ici on récupere qui est connécté ( admin, manager .. ) et on le SET à l'article :
        $user = $security->getUser();
        $article->setUser($user);
        $form = $this->createForm(ArticleFormType::class, $article); 

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleRepository->add($article, true);
             
            return $this->redirectToRoute("app_back_articles");
        }

        return $this->renderForm('back-office/article/add.html.twig', [
             'form' => $form,
        ]);
     }

     /**
     * @Route("/back-office/articles/{id}/modifier", name="app_back_articles_edit", methods={"GET", "POST"})
     */
    public function edit($id, Request $request, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);

        if (!$article) {
            return $this->render('front/errors/404.html.twig');
        }

        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleRepository->add($article, true);

            return $this->redirectToRoute('app_back_articles');
        }

        return $this->renderForm('back-office/article/edit.html.twig', [
            'article' => $article,
            'form' => $form
        ]);
    }
}

