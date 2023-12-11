<?php

namespace App\Controller\BackOffice;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        // On recupere l'article
        $article = $articleRepository->find($id);
        
        $articleRepository->remove($article, $flush = true);
        
        return $this->redirectToRoute("app_back_articles");
    }

    /**
     * @Route("/back-office/articles/ajouter", name="app_back_articles_add")
     */
    public function create(Request $request, ArticleRepository $articleRepository)
    {
        // On créer une instance de Movie car ici on veut créer un article
        $article = new Article();
        // On créer notre formulaire et on le stock dans $form
        $form = $this->createForm(ArticleFormType::class, $article); // Dans le formualire on va modifier $article

        // Ici j'intercepte le contenu de la requete
        $form->handleRequest($request);
        // Ici je check si le formulaire a été soumis et validé
        if ($form->isSubmitted() && $form->isValid()) {

            // On rentre dans le if SI le formulaire a été soumis
            // C'est donc ici qu'on va envoyer les données de $form dans la bdd
            // J'envoie $article en bdd, true => pour faire le flush
            $articleRepository->add($article, true);
            
           
            return $this->redirectToRoute("app_back_articles");
        }

        // On retourne la vue voulue en lui passant le formulaire $form
        return $this->renderForm('back-office/article/add.html.twig', [
            'form' => $form,
            
        ]);
    }

    
}
