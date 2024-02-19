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
        // $post1 = new Post();
        // $post1->setTitle('Welcome to France');
        // $post1->setContent('Paris is the best city through the World.');
        // $post1->setCreatedAt(new DateTime());
        // $manager->persist($post1);

        // $post2 = new Post();
        // $post2->setTitle('Hello World');
        // $post2->setContent('It\'s the first sentence that we provide for the first time.');
        // $post2->setCreatedAt(new DateTime());
        // $manager->persist($post2);

        // $post3 = new Post();
        // $post3->setTitle('Test');
        // $post3->setContent('This is a test to check if everything is okay.');
        // $post3->setCreatedAt(new DateTime());
        // $manager->persist($post3);

        $manager->flush();
    }
}
