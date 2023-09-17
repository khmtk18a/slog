<?php

namespace App\EventListener;

use App\Entity\Vote;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Vote::class)]
class VoteListener
{
    public function __construct()
    {
    }

    public function prePersist(Vote $vote, PrePersistEventArgs $event): void
    {
        $post = $vote->getPost();
        $post->setScore($post->getScore() + $vote->getValue());

        $event->getObjectManager()->persist($post);
    }
}
