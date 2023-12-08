<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $roles = ['ROLE_ADMIN', 'ROLE_MANAGER', ''];

        for ($i = 0; $i < 6; $i++) {

            $user = new User();

            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setRoles([$roles[rand(0, 2)]]);
            $user->setEmail($faker->email());
            $user->setPassword($faker->password(5, 30));

            $manager->persist($user);
            $this->addReference('user-' . $i, $user);
        }

        $manager->flush();
    }
}
