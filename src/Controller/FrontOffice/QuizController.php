<?php

namespace App\Controller\FrontOffice;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class QuizController extends AbstractController
{
    /**
     * @Route("/les-quiz", name="app_quiz_list")
     */
    public function list(QuizRepository $quizRepository): Response
    {
        $quizs = $quizRepository->findAll();

        return $this->render('front-office/quiz/list.html.twig', [
            'quizs' => $quizs,
        ]);
    }

    /**
     * details of a section
     *
     * @Route("/les-quiz/{title}/{id}", name="app_quiz_show", methods={"GET"})
     * 
     */
    public function show(int $id, QuizRepository $quizRepository, QuestionRepository $questionRepository, SessionInterface $sessionInterface)
    {


        $quiz = $quizRepository->find($id);

        // Retrieves the ID of the quiz currently in session.
        $currentQuizId = $sessionInterface->get('current_quiz_id', null);

        // Checks whether the user has started a new quiz or is continuing the same one.
        if ($currentQuizId !== $id) {
            // If this is a new quiz, load 10 random questions and reset the offset.
            $questions = $questionRepository->findRandomQuestionByQuiz($quiz, 10);
            $sessionInterface->set('questions', $questions);
            $sessionInterface->set('offset', 0);
            $sessionInterface->set('current_quiz_id', $id);
            $offset = 0;
        } else {
            //Otherwise, continue with current questions and offset
            $questions = $sessionInterface->get('questions', []);
            $offset = $sessionInterface->get('offset', 0);
        }

        // dump the number of questions answered
        dump($offset);
        if (!isset($questions[$offset])) {

            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }

        $currentQuestion = $questions[$offset];

        return $this->render('front-office/quiz/show.html.twig', [
            'quiz' => $quiz,
            'questions' => $currentQuestion
        ]);
    }



    /**
     * GEstion des question
     *
     * @Route("/les-quiz/{title}/{id}", name="app_quiz_submit", methods={"post"})
     * 
     */
    public function quizSubmit(Quiz $quiz, SessionInterface $sessionInterface, Request $request)
    {
        $questions = $sessionInterface->get('questions', []);
        $offset = $sessionInterface->get('offset', 0);

        $offset++;

        $sessionInterface->set('offset', $offset);

        if ($offset <= 10) {
            return $this->redirectToRoute('app_quiz_show', ['title' => $quiz->getTitle(), 'id' => $quiz->getId()]);
        }
    }
}
