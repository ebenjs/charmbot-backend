<?php

namespace App\DataFixtures;

use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $quote = new Quote();
            $quote->setPhrase($faker->sentence);
            $quote->setAuthor($faker->name);
            $manager->persist($quote);
        }

        $manager->flush();
    }
}
