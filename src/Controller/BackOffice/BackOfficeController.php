<?php

namespace App\Controller\BackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BackOfficeController extends AbstractController
{
    /**
     * @Route("/back-office", name="app_back_office")
     */
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MANAGER')) {
            
            return $this->render('bundles/TwigBundle/Exception/error403.html.twig');
        }
        return $this->render('back-office/homeBackOffice.html.twig');
    }
}