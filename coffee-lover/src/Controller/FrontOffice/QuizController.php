<?php

namespace App\Controller\FrontOffice;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    /**
     * @Route("/les-quizs", name="app_quiz_list")
     */
    public function list(QuizRepository $quizRepository): Response
    {   
        $quizs = $quizRepository->findAll();
        
        return $this->render('quiz/list.html.twig', [
            'quizs' => $quizs,
        ]);
    }
}
