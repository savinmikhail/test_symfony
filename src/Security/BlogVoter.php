<?php

// src/Security/PostVoter.php
namespace App\Security;

use App\Entity\Blog;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BlogVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Blog) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to `supports()`
        /** @var Blog $blog */
        $blog = $subject;

        return match($attribute) {
            self::VIEW => $this->canView($blog, $user),
            self::EDIT => $this->canEdit($blog, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(Blog $blog, User $user): bool
    {
        return true;
    }

    private function canEdit(Blog $blog, User $user): bool
    {
        // this assumes that the Post object has a `getOwner()` method
        return $user === $blog->getUser();
    }
}