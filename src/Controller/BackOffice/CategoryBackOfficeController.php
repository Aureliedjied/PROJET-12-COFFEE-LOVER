<?php

namespace App\Controller\BackOffice;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryBackOfficeController extends AbstractController
{
    /**
     * @Route("/back-office/categories", name="app_back_categories")
     */
    public function list(CategoryRepository $categoryRepository): Response
    {
       

        return $this->render('back-office/category/list.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
