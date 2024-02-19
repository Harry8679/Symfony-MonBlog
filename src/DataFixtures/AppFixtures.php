<?php

namespace App\DataFixtures;

use App\Entity\Post;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($p = 0; $p < mt_rand(15, 25); $p++) {
            $post = new Post();
            $words = implode(' ', $faker->words($nb = mt_rand(3, 5), $asText = false));
            $post->setTitle($words)
                 ->setContent($faker->realText())
                 ->setAuthor($faker->name)
                 ->setCreatedAt($faker->dateTimeBetween('-100 days', '-1 days'));
            $manager->persist($post);
        }

        $manager->flush();
    }
}
