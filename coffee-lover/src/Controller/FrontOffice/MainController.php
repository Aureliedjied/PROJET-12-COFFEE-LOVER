<?php

namespace App\Controller\FrontOffice;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home(ArticleRepository $articleRepository): Response
    {
        $saviezVous = "home";
        $homeArticle = $articleRepository->findHomeArticle($saviezVous);


        $randomArticle = $articleRepository->findRandomArticles();
        dump($homeArticle);

        return $this->render('main/index.html.twig', [
            'homeArticle' => $homeArticle,
            'randomArticle' => $randomArticle
        ]);
    }
}
