<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encode;
    
    public function __construct(UserPasswordHasherInterface $encode)
    {
        $this->encode = $encode;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($u = 0; $u < mt_rand(5, 10); $u++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setFirstName($faker->lastName);
            $user->setLastName($faker->firstName);
            $password = $this->encode->hashPassword($user, 'Azerty123');
            $user->setPassword($password);

            $manager->persist($user);
                //  ->setPassword($encode->hashPassword($user, 'Azerty123'));

                for ($p = 0; $p < mt_rand(10, 20); $p++) {
                    $post = new Post();
                    $words = implode(' ', $faker->words($nb = mt_rand(3, 5), $asText = false));
                    $post->setTitle($words)
                         ->setContent($faker->realText())
                         ->setUser($user)
                         ->setCreatedAt($faker->dateTimeBetween('-100 days', '-1 days'));

                    $manager->persist($post);
                }
        }

        $manager->flush();
    }
}
