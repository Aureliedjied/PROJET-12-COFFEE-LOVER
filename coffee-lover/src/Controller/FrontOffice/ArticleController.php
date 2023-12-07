<?php

namespace App\Controller\FrontOffice;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/{tag}")
 * @ParamConverter("article", options={"mapping": {"tag": "tag"}})
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_categorie")
     */
    
    public function list(ArticleRepository $articleRepository, Article $article): Response
    {
        // Display all articles related to a tag from the database.
        
        $articles = $articleRepository->findAllByTag(['tag'=>$article->getTag()]);

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{title}", name="app_article_show")
     * composer sensio for transform id in title
     * @ParamConverter("article", options={"mapping": {"title": "title"}})
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
    // public function list(ArticleRepository $articleRepository): Response
    // {
    //     // Display all articles related to a tag from the database.
    //     $articles = 'transformation';
    //     $tagArticle = $articleRepository->findAllByTag($articles);

    //     return $this->render('article/list.html.twig', [
    //         'tagArticle' => $tagArticle,
    //     ]);
    // }
}
