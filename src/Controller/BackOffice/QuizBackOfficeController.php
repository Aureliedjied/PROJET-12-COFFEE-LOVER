<?php

namespace App\Controller\BackOffice;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuizRepository;
use App\Repository\QuestionRepository;
use App\Repository\ResponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back-office")
 */
class QuizBackOfficeController extends AbstractController
{
    /**
     * @Route("/quiz", name="app_back_quiz")
     */
    public function list(QuizRepository $quizRepository): Response
    {
        $quizs = $quizRepository->findAll();

        return $this->render('back-office/quiz/list.html.twig', [
            'quizs' => $quizs,

        ]);
    }

    /**
     * Display questions for each quizId 
     * 
     * @Route("/quiz/question/{title}/{id}", name="app_back_quiz_show", methods={"GET"})
     * 
     */
    public function show(int $id, QuizRepository $quizRepository, Quiz $quiz)
    {
        $quiz = $quizRepository->find($quiz);
        $questions = $quiz->getQuestion();

        return $this->render('back-office/quiz/show.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions,
        ]);
    }




    // ! Question

    /**
     * @Route("/quiz/ajouter", name="app_back_quiz_add")
     */
    public function create(Request $request, QuestionRepository $questionRepository): Response
    {
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question, ['add_mode' => true]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $questionRepository->add($question, true);

            return $this->redirectToRoute('app_back_quiz');
        }

        return $this->renderForm('back-office/quiz/add.html.twig', [
            'form' => $form
        ]);
    }




    /**
     * @Route("/quiz/modifier/{id}", name="app_back_quiz_edit")
     */
    public function edit(int $id, QuestionRepository $questionRepository, Request $request): Response
    {
        $question = $questionRepository->find($id);



        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $questionRepository->add($question, true);

            return $this->redirectToRoute('app_back_articles');
        }

        return $this->renderForm('back-office/quiz/edit.html.twig', [
            'form' => $form,
            'question' => $question,
        ]);
    }



    /**
     * @Route("/quiz/delete/{id}", name="app_back_quiz_delete")
     */
    public function delete($id, QuestionRepository $questionRepository): Response
    {
        $question = $questionRepository->find($id);

        $questionRepository->remove($question, true);

        return $this->redirectToRoute('app_back_quiz_show');
    }
}
