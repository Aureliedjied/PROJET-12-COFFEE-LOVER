<?php

namespace App\Controller\BackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/back-office", name="app_back_office")
     */
    public function index(): Response
    {
        return $this->render('backOffice/homeBackOffice.html.twig');
    }
}
