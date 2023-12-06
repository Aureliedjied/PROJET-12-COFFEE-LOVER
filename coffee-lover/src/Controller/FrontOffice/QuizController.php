<?php

namespace App\Controller\FrontOffice;

use App\Entity\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\QuizRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * details of a section
     *
     * @Route("/{title}/quiz/{id}", name="app_quiz_show", methods={"GET"})
     * 
     */
    public function show(Quiz $quiz, QuizRepository $quizRepository, QuestionRepository $questionRepository)
    {


        if (!$quiz) {
            // Gérer le cas où le quiz n'existe pas
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }


        $questions = $questionRepository->findRandomQuestionByQuiz($quiz, $limit = 10);


        if ($quiz === null) {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }
}
