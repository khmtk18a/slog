<?php

namespace App\Security\Voter;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string,Post>
 */
class AdminVoter extends Voter
{
    public const ADMIN = 'for_admin';
    public const CAN_MODIFY = 'can_modify';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::ADMIN, self::CAN_MODIFY]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::ADMIN:
                if ($user->isAdmin()) {
                    return true;
                }
                break;

            case self::CAN_MODIFY:
                if ($user === $subject->getUser()) {
                    return true;
                }
                break;
        }

        return false;
    }
}
