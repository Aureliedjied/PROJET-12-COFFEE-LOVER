<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Article;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [UserFixtures::class, CategoryFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {

            $article = new Article();

            $article->setUser($this->getReference('user-' . rand(0, 5)));
            $article->setCategory($this->getReference('category-' . rand(0, 3)));
            $article->setTitle($faker->unique()->word());
            $article->setSubtitle($faker->word());
            $article->setContent($faker->paragraph());
            $article->setCreatedAt(new \DateTimeImmutable());
            $slug = $slugger->slug($article->getTitle())->lower();
            $article->setSlug($slug);

            $manager->persist($article);
        }


        $manager->flush();
    }
}
