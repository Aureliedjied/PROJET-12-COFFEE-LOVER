<?php

namespace App\Controller\FrontOffice;

use App\Repository\PlayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $playRepository;

    public function __construct(PlayRepository $playRepository)
    {
        $this->playRepository = $playRepository;
    }

    /**
     * @Route("/mon-profil", name="app_profil")
     */
    public function index(): Response
    {
        return $this->render('front-office/user/profil.html.twig', []);
    }

    /**
     * @Route("/mon-profil/recompenses", name="app_profil_show")
     */
    public function show(): Response
    {
        return $this->render('front-office/user/show.html.twig', []);
    }
}
