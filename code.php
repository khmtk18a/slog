<?php
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string,string>
 */
class Code extends Voter
{
    const GING = 1;
	protected function supports(string $attribute, mixed $subject) {
        return true;
	}

	protected function voteOnAttribute($attribute, mixed $subject, Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token) {
	}
}
