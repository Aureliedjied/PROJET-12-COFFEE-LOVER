<?php

namespace App\Controller\FrontOffice;


use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home(ArticleRepository $articleRepository): Response
    {


        // methode which retrieves 2 random articles
        $randomArticle = $articleRepository->findRandomArticles();

        // return articles to the view
        return $this->render('front-office/main/home.html.twig', [
            'randomArticle' => $randomArticle
        ]);
    }

    /**
     * @Route("/a-propos", name="app_contact")
     */
    public function contact(): Response
    {

        // return contact to the view
        return $this->render('front-office/main/contact.html.twig');
    }
    /**
     * @Route("/a-propos/mention-legal", name="app_mention_legal")
     */
    public function mention(): Response
    {

        // return contact to the view
        return $this->render('front-office/main/mentionLegal.html.twig');
    }


    /**
     * @Route("/search", name="app_search", methods={"GET"})
     */
    public function search(Request $request, ArticleRepository $articleRepository): JsonResponse
    {
        // On recupere le formulaire via 'searchTerm' 
        $query = $request->query->get('searchTerm');
        // On recup la méthode du repository qui recherche par titre
        $results = $articleRepository->searchArticle($query);
        // on converti les resultatst dans un tableau asso
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'title' => $result->getTitle(),
                'url' => $this->generateUrl('app_article_show', [
                'categorySlug' => $result->getCategory()->getSlug(),
                'articleSlug' => $result->getSlug(),
            ]),
            ];
        }
        // On renvois la réponse en JSON
        return new JsonResponse($data);
    }
}
