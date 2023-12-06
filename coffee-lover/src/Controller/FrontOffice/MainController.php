<?php

namespace App\Controller\FrontOffice;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home(ArticleRepository $articleRepository): Response
    {
        // retrieve articles from database
        $home = "home";
        // $homeArticle = $articleRepository->findHomeArticle($saviezVous);
        $homeArticle = $articleRepository->findAllByTag($home);

        // methode which retrieves 2 random articles
        $randomArticle = $articleRepository->findRandomArticles();
        dump($homeArticle);
        // return articles to the view
        return $this->render('main/index.html.twig', [
            'homeArticle' => $homeArticle,
            'randomArticle' => $randomArticle
        ]);
    }
}
