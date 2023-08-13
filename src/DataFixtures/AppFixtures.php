<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // create admin user
        $admin = (new User())
            ->setGoogleId('113493657564122458227')
            ->setName('ging-dev')
            ->setPhoto('https://avatars.githubusercontent.com/u/42226341');

        $manager->persist($admin);
        $manager->flush();

        // create posts
        for ($i = 0; $i < 20; ++$i) {
            $post = new Post();
            $post->setTitle('Post #'.$i);
            $post->setContent('This is content of post #'.$i);
            $post->setUser($admin);
            $manager->persist($post);
        }

        $manager->flush();
    }
}
