<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\AsciiSlugger;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();

        $categories = ['Botanique et culture', 'Récolte et transformation', 'Torréfaction et méthodes d\'extraction', 'Café de spécialité'];

        for ($i = 0; $i < count($categories); $i++) {

            $category = new Category();

            $category->setTitle($categories[$i]);
            $category->setSlug($slugger->slug($categories[$i])->lower());

            $manager->persist($category);
            $this->addReference('category-' . $i, $category);
        }

        $manager->flush();
    }
}
