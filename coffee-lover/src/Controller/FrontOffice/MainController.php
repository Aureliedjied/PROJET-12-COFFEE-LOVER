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
        // récuperation de l'article le saviez-vous dans la table article dans la BDD
        $saviezVous = "home";
        $homeArticle = $articleRepository->findHomeArticle($saviezVous);

        // récuperation de deux articles dans la bdd en mode random 
        $randomArticle = $articleRepository->findRandomArticles();
        dump($homeArticle);
        // retourne les articles à la vue twig home
        return $this->render('main/index.html.twig', [
            'homeArticle' => $homeArticle,
            'randomArticle' => $randomArticle
        ]);
    }
}
