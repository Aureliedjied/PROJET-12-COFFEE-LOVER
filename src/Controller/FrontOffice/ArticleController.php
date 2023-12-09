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
        return $this->render('front-office/article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{categorySlug}/{articleSlug}", name="app_article_show")
     */
    public function show(string $articleSlug, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->findOneBy(['slug' => $articleSlug]);

        if (!$article) {
            // Gérer l'absence de l'article
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }

        return $this->render('front-office/article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
