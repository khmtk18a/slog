<?php

namespace App\EventListener;

use App\Entity\Post;
use App\Repository\CommentRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postLoad, method: 'prePersist', entity: Post::class)]
class PostListener
{
    public function __construct(private CommentRepository $commentRepository)
    {
    }

    public function prePersist(Post $post, PostLoadEventArgs $event): void
    {
        $commentsCount = $this->commentRepository->countByPost($post);
        $post->setCommentsCount($commentsCount);
    }
}
