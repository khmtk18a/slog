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
        // Create admin user
        $admin = (new User())
            ->setGoogleId('113493657564122458227')
            ->setName('Thanh Trần')
            ->setPhoto('https://avatars.githubusercontent.com/u/42226341')
            ->setAdmin(true);

        $manager->persist($admin);
        $manager->flush();

        // Create posts
        for ($i = 0; $i < 25; ++$i) {
            $post = new Post();
            $post->setTitle('Post #'.$i);
            $post->setContent('This is content of post #'.$i);
            $post->setScore(random_int(0, 100));
            $post->setUser($admin);

            $commentCount = random_int(0, 20);
            for ($j = 0; $j < $commentCount; ++$j) {
                $comment = new Comment();
                $comment->setUser($admin);
                $comment->setContent('comment #'.$j);
                $comment->setPost($post);

                $manager->persist($comment);

                $subCommentCount = random_int(0, 5);
                for ($k = 0; $k < $subCommentCount; ++$k) {
                    $subComment = new Comment();
                    $subComment->setUser($admin);
                    $subComment->setContent('sub comment #'.$k);
                    $subComment->setParent($comment);

                    $manager->persist($subComment);
                }
            }

            $manager->persist($post);
        }

        $manager->flush();
    }
}
