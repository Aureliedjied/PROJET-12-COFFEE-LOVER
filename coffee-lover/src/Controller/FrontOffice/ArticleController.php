<?php

namespace App\Controller\FrontOffice;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function list(ArticleRepository $articleRepository): Response
    {
        $articles = 'torrefaction';
        $tagArticle = $articleRepository->findAllByTag($articles);

        return $this->render('article/list.html.twig', [
            'tagArticle' => $tagArticle,
        ]);
    }
}
