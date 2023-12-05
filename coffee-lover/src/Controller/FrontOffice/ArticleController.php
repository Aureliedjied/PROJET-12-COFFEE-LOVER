<?php

namespace App\Controller\FrontOffice;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function list(ArticleRepository $articleRepository): Response
    {
        // Display all articles related to a tag from the database.
        $articles = 'torrefaction';
        $tagArticle = $articleRepository->findAllByTag($articles);

        return $this->render('article/list.html.twig', [
            'tagArticle' => $tagArticle,
        ]);
    }

    /**
     * @Route("/categorie/{title}", name="app_article_show")
     * @ParamConverter("article", options={"mapping": {"title": "title"}})
     */
    public function show(Article $article)
    {
        // Retrieving an article based on its title from the database.

        // $article = $articleRepository->find($title);

        // Error page if the article does not exist."
            if ($article === null) {
                return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
            }
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
