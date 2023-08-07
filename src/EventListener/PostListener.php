<?php

namespace App\EventListener;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsEntityListener(Events::prePersist, method: 'prePersist', entity: Post::class)]
#[AsEntityListener(Events::preUpdate, method: 'preUpdate', entity: Post::class)]
class PostListener
{
    public function __construct(private Security $security)
    {
    }

    public function prePersist(Post $post, PrePersistEventArgs $event)
    {
        $user = $this->security->getUser();

        if (null === $user) {
            return;
        }

        $post->setUser($user);
        $post->setCreatedAt(new \DateTime());
        $post->setUpdatedAt(new \DateTime());
    }

    public function preUpdate(Post $post, PreUpdateEventArgs $event)
    {
        $post->setUpdatedAt(new \DateTime());
    }
}
