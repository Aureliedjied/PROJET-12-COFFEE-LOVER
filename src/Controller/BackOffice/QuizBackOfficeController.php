<?php

namespace App\Controller\BackOffice;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\Response;
use App\Form\QuestionType;
use App\Repository\QuizRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\EventSubscriber\PaginationSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/back-office")
 */
class QuizBackOfficeController extends AbstractController
{
    private $entityManager;
    private $paginationSubscriber;
    private $paginator;

    public function __construct(EntityManagerInterface $entityManager,  PaginationSubscriber $paginationSubscriber, PaginatorInterface $paginator)
    {

        $this->entityManager = $entityManager;

        $this->paginationSubscriber = $paginationSubscriber;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/quiz", name="app_back_quiz")
     */
    public function list(QuizRepository $quizRepository): \Symfony\Component\HttpFoundation\Response
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
    public function show(int $id, QuizRepository $quizRepository, QuestionRepository $questionRepository, Quiz $quiz,  PaginatorInterface $paginator, Request $request)
    {
        $quiz = $quizRepository->find($id);
        $questions = $quiz->getQuestions();

        $pagination = $paginator->paginate(
            $questions,
            $request->query->getInt('page', 1), // Start to page number 1
            10 // 10 questions par page
        );


        return $this->render('back-office/quiz/show.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions,
            'pagination' => $pagination,
        ]);
    }




    // ! Question

    /**
     * @Route("/quiz/ajouter", name="app_back_quiz_add")
     */
    public function create(Request $request,  EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $question = new Question();
        for ($i = 0; $i < 3; $i++) {
            $question->getResponses()->add(new Response());
        }

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {



            foreach ($question->getResponses() as $response) {
                if ($response->getQuestion() === null) {
                    $response->setQuestion($question);
                }
            }


            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute('app_back_quiz');
        }

        return $this->renderForm('back-office/quiz/add.html.twig', [
            'form' => $form
        ]);
    }




    /**
     * @Route("/quiz/modifier/{id}", name="app_back_quiz_edit")
     */
    public function edit(int $id,  QuestionRepository $questionRepository, Request $request,   EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $question = $questionRepository->find($id);


        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($question->getResponses() as $response) {
                if ($response->getQuestion() === null) {
                    $response->setQuestion($question);
                }
            }


            $entityManager->persist($question);

            $entityManager->flush();

            return $this->redirectToRoute('app_back_quiz');
        }
        return $this->renderForm('back-office/quiz/edit.html.twig', [
            'form' => $form,
            'question' => $question,
        ]);
    }



    /**
     * @Route("/quiz/delete/{quizId}/{questionId}/{quizTitle}", name="app_back_quiz_delete")
     */
    public function delete($quizId, $questionId, $quizTitle, QuestionRepository $questionRepository): \Symfony\Component\HttpFoundation\Response
    {
        $question = $questionRepository->find($questionId);
        $questionRepository->remove($question, true);

        return $this->redirectToRoute('app_back_quiz_show', ['id' => $quizId, 'title' => $quizTitle]);
    }
}
