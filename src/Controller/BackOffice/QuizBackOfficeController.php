<?php

namespace App\Controller\BackOffice;

use App\Repository\QuizRepository;
use App\Repository\QuestionRepository;
use App\Repository\ResponseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuizBackOfficeController extends AbstractController
{
    /**
     * @Route("/back-office/quiz", name="app_back_quiz")
     */
    public function list($questionId, QuizRepository $quizRepository, QuestionRepository $questionRepository, ResponseRepository $responseRepository): Response
    {


        return $this->render('back-office/quiz/list.html.twig', [
            'quizs' => $quizRepository->findAll(),
            // 'questions' => $questionRepository->find($questionId),
            // 'responses' => $responseRepository->find($questionId),

        ]);
    }
}
