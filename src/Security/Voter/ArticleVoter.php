<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['EDIT', 'DELETE'])
            && $subject instanceof Article;
    }

    protected function voteOnAttribute($attribute, $article, TokenInterface $token)
    {

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if( null === $article->getAuthor()) {
            return false;
        }

        switch ($attribute) {
            case 'EDIT':
                return ('ROLE_ADMIN' === $user->getRoles()[0] || 'ROLE_WRITER' === $user->getRoles()[0] && ($user->getID() === $article->getAuthor()->getID())) ? true : false;
                break;
            case 'DELETE':
                return ('ROLE_ADMIN' === $user->getRoles()[0] || 'ROLE_WRITER' === $user->getRoles()[0] && ($user->getID() === $article->getAuthor()->getID())) ? true : false;
                break;
        }

        return false;
    }
}
