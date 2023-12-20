<?php

namespace App\Controller\FrontOffice;

use App\Entity\Play;
use App\Entity\Quiz;
use App\Repository\PlayRepository;
use App\Repository\QuizRepository;
use App\Repository\RewardRepository;
use App\Repository\QuestionRepository;
use App\Repository\ResponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class QuizController extends AbstractController
{
    private $playRepository;
    private $rewardRepository;
    private $entityManager;

    public function __construct(PlayRepository $playRepository, RewardRepository $rewardRepository, EntityManagerInterface $entityManager)
    {
        $this->playRepository = $playRepository;
        $this->rewardRepository = $rewardRepository;
        $this->entityManager = $entityManager;
    }


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
     * question display
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
            //initialize score
            $sessionInterface->set('score', 0);
            $sessionInterface->set('offset', 0);
            $sessionInterface->set('current_quiz_id', $id);
            $offset = 0;
        } else {
            //Otherwise, continue with current questions and offset
            $questions = $sessionInterface->get('questions', []);
            $offset = $sessionInterface->get('offset', 0);
        }

        $score = $sessionInterface->get('score', 0);
        // dump the number of questions answered
        dump($offset);


        if ($offset >= count($questions)) {
            return $this->redirectToRoute('app_quiz_result', [
                'id' => $id
            ]);
        }

        $currentQuestion = $questions[$offset];

        return $this->render('front-office/quiz/show.html.twig', [
            'quiz' => $quiz,
            'questions' => $currentQuestion,
            'score' => $score,
            'offset' => $offset + 1,

        ]);
    }



    /**
     * Questions managing
     *
     * @Route("/les-quiz/{title}/{id}", name="app_quiz_submit", methods={"post"})
     * 
     */
    public function quizSubmit(Quiz $quiz, SessionInterface $sessionInterface, ResponseRepository $responseRepository, Request $request)
    {
        $questions = $sessionInterface->get('questions', []);
        $offset = $sessionInterface->get('offset', 0);
        $score = $sessionInterface->get('score', 0);

        $responseId = $request->request->get('response');


        $selectedResponse = $responseRepository->find($responseId);

        //check if the answer is correct
        // dump($sessionInterface->get('score'));

        if ($selectedResponse->isIsCorrect()) {
            $score++;
        }

        //Increment the offset for the next question and increment score if reponse is correct.
        $score = $sessionInterface->set('score', $score);
        $offset++;
        $sessionInterface->set('offset', $offset);

        if ($offset >= 11) {
            return $this->redirectToRoute('app_quiz_result', [
                'title' => $quiz->getTitle(),
                'id' => $quiz->getId()
            ]);
        }


        return $this->redirectToRoute('app_quiz_show', ['title' => $quiz->getLink(), 'id' => $quiz->getId()]);
    }

    /**
     * @Route("/les-quiz-resultat/{id}", name="app_quiz_result")
     */
    public function quizResult(int $id, QuizRepository $quizRepository, SessionInterface $sessionInterface): Response
    {
        // Retrieve the quiz by ID
        $quiz = $quizRepository->find($id);

        // Check if quiz exist
        if (!$quiz) {
            throw $this->createNotFoundException('Le quiz demandé n\'existe pas.');
        }

        // Retrieve the session score
        $score = $sessionInterface->get('score', 0);

        $this->saveUserScore($score, $quiz);

        if ($score > 5) {
            $this->getReward($score, $quiz);
        }

        // Send the data to the Twig template
        return $this->render('front-office/quiz/result.html.twig', [
            'quiz' => $quiz,
            'score' => $score,
        ]);
    }


    public function saveUserScore($score, $quiz)
    {
        $user = $this->getUser();
        if (!$user) {
            // if user is't connected, redirect him to connexion page
            return $this->redirectToRoute('app_home');
        }

        $existingPlay = $this->playRepository->findOneBy(['user' => $user, 'quiz' => $quiz]);
        if ($existingPlay) {

            if ($score > $existingPlay->getScore()) {
                $existingPlay->setScore($score);
                $this->playRepository->add($existingPlay, true);
            }
        } else {
            $play = new Play();
            $play->setUser($user);
            $play->setQuiz($quiz);
            $play->setStatus(1);
            $play->setScore($score);


            $this->playRepository->add($play, true);
        }
    }


    public function getReward($score, $quiz)
    {

        $user = $this->getUser();

        //retrieve a reward in random via rewardrepository randomreward method
        $reward = $this->rewardRepository->findReward($user->getId());
        //check if the user already has the reward in question, otherwise do again the method

        if ($reward) {
            $user->addReward($reward);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }
}
