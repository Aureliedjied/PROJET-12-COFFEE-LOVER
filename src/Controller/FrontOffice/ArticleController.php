<?php

namespace App\Controller\FrontOffice;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/articles")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/{categorySlug}", name="app_categorie")
     */
    public function getArticlesByCategory(string $categorySlug, CategoryRepository $categoryRepository, ArticleRepository $articleRepository)
    {
        $category = $categoryRepository->findOneBy([
            'slug' => $categorySlug,
        ]);

        $articles = $articleRepository->findBy([
            'category' => $category,
        ]);
        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{categorySlug}/{articleSlug}", name="app_article_show")
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
