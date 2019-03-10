<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/10/19
 * Time: 8:01 AM
 */

namespace App\Security;


use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MicroPostVoter extends Voter
{

    const EDIT = 'edit';
    const DELETE = 'delete';
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])){
            return false;
        }

        if (!$subject instanceof MicroPost){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $authenticatedUser = $token->getUser();
        if (!$authenticatedUser instanceof User){
            return false;

        }
        /**
         * @var MicroPost $microPost
         */
        $microPost = $subject;
        
        return $microPost->getUser()->getId() === $authenticatedUser->getId();
    }
}