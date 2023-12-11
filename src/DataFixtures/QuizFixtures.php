<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\Response;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class QuizFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['QuizFixtures'];
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugger = new AsciiSlugger();
        $quizTitles = ['Botanique et culture', 'Récolte et transformation', 'Torréfaction et méthodes d\'extraction', 'Café de spécialité'];

        foreach ($quizTitles as $title) {
            $quiz = new Quiz();
            $quiz->setUser($this->getReference('user-' . rand(0, 5)));
            $quiz->setTitle($title);
            $quiz->setLink($slugger->slug($title)->lower());

            for ($i = 0; $i < 15; $i++) {
                $question = new Question();
                $question->setTextQuestion($faker->sentence($nbWords = 6, $variableNbWords = true));

                for ($j = 0; $j < 3; $j++) {
                    $response = new Response();
                    $response->setTextResponse($faker->sentence($nbWords = 4, $variableNbWords = true));
                    $response->setIsCorrect($j == 0);
                    $question->addResponse($response);
                    $manager->persist($response);
                }

                $quiz->addQuestion($question);
                $manager->persist($question);
            }

            $manager->persist($quiz);
        }
        $manager->flush();
    }
}
