<?php

namespace App\Controller\BackOffice;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\EventSubscriber\PaginationSubscriber; 
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/back-office")
 */
class ArticleBackOfficeController extends AbstractController
{
    private $paginationSubscriber;
    private $paginator;

    public function __construct(
        PaginationSubscriber $paginationSubscriber,
        PaginatorInterface $paginator
    ) {
        $this->paginationSubscriber = $paginationSubscriber;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/articles", name="app_back_articles")
     */
    public function list(Request $request, ArticleRepository $articleRepository): Response
    {
        $pagination = $this->paginator->paginate(
            $articleRepository->findAll(),
            // Start to page number 1 :
            $request->query->getInt('page', 1), 
            // 10 per page :
            10 
        );

        return $this->render('back-office/article/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * delete article
     *
     * @Route("/articles/delete/{id}", name="app_back_articles_delete")
     */
    public function delete($id, ArticleRepository $articleRepository)
    {
        //  We retrieve the article
        $article = $articleRepository->find($id);
        
        $articleRepository->remove($article, true);
        
        return $this->redirectToRoute("app_back_articles");
    }

    /**
    * @Route("/articles/ajouter", name="app_back_articles_add")
    */
    public function create(Request $request, ArticleRepository $articleRepository, Security $security)
    {

        $article = new Article();
        // here, we retrieve the user connected ( admin, manager .. ) and we SET thearticle :
        $user = $security->getUser();
        $article->setUser($user);
        $form = $this->createForm(ArticleFormType::class, $article); 

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleRepository->add($article, true);
            $this->addFlash('success', 'Ajout effectué avec succès !');
            return $this->redirectToRoute("app_back_articles");
        }

        return $this->renderForm('back-office/article/add.html.twig', [
             'form' => $form,
        ]);
     }

     /**
     * @Route("/articles/{id}/modifier", name="app_back_articles_edit", methods={"GET", "POST"})
     */
    public function edit($id, Request $request, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);

        if (!$article) {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }

        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $articleRepository->add($article, true);
            $this->addFlash('success', 'Modifié avec succès !');
            return $this->redirectToRoute('app_back_articles');
        }

        return $this->renderForm('back-office/article/edit.html.twig', [
            'article' => $article,
            'form' => $form
        ]);
    }
}

