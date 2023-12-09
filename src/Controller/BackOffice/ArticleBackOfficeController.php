<?php

namespace App\Controller\BackOffice;

use App\Repository\ArticleRepository;
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
}
