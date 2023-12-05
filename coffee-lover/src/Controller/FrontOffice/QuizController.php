<?php

namespace App\Controller\FrontOffice;

use App\Entity\Quiz;
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

    /**
     * details of a section
     *
     * @Route("/{title}/quiz/{id}", name="app_quiz_show", methods={"GET"})
     */
    public function show(Quiz $quiz, QuizRepository $quizRepository)
    {

        // depuis la methode custom faite sur le casting repository on recupere les castings d'un film
         $quiz = $quizRepository->find($quiz);

        // Si le film demandé n'existe pas getMovieById($id) va me retourner null
        if ($quiz === null) {
            throw $this->createNotFoundException('Quiz non trouvé');
        }
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }





}
