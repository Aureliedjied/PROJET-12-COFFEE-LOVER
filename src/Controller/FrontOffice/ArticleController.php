<?php

namespace App\Controller\FrontOffice;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/articles")
 * 
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/{tag}", name="app_categorie")
     */

    public function list(ArticleRepository $articleRepository, Article $article): Response
    {
        // Display all articles related to a tag from the database.

        $articles = $articleRepository->findAllByTag(['tag' => $article->getTag()]);

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{tag}/{title}", name="app_article_show")
     * 
     */
    public function show(Article $article)
    {

        // Error page if the article does not exist."
        if ($article === null) {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
