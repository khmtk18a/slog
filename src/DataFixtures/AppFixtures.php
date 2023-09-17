<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create admin user
        $admin = (new User())
            ->setGoogleId('113493657564122458227')
            ->setName('Thanh Trần')
            ->setPhoto('https://avatars.githubusercontent.com/u/42226341')
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $manager->flush();

        // create posts
        for ($i = 0; $i < 20; ++$i) {
            $post = new Post();
            $post->setTitle('Post #'.$i);
            $post->setContent('This is content of post #'.$i);
            $post->setUser($admin);

            for ($j = 0; $j < 5; ++$j) {
                $comment = new Comment();
                $comment->setUser($admin);
                $comment->setContent('comment #'.$j);
                $comment->setPost($post);
                $manager->persist($comment);

                $subComment = new Comment();
                $subComment->setUser($admin);
                $subComment->setContent('sub comment #'.$j);
                $subComment->setParent($comment);
                $manager->persist($subComment);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }
}
