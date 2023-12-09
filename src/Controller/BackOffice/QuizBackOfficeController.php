<?php

namespace App\Controller\BackOffice;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizBackOfficeController extends AbstractController
{
    /**
     * @Route("/back-office/quiz", name="app_back_quiz")
     */
    public function list(QuizRepository $quizRepository): Response
    {
       

        return $this->render('back-office/quiz/list.html.twig', [
            'quizs' => $quizRepository->findAll(),
        ]);
    }
}
