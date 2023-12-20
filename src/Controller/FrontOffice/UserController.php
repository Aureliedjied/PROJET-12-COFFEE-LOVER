<?php

namespace App\Controller\FrontOffice;

use App\Repository\PlayRepository;
use App\Repository\RewardRepository;
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
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_security_login');
        } else {
            return $this->render('front-office/user/profil.html.twig', []);
        }
    }

    /**
     * @Route("/mon-profil/recompenses/{id}", name="app_profil_show")
     */
    public function show(RewardRepository $rewardRepository, int $id): Response
    {
        $reward = $rewardRepository->find($id);

        return $this->render('front-office/user/show.html.twig', [
            'reward' => $reward
        ]);
    }
}
