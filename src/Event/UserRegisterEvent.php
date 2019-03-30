<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/25/19
 * Time: 3:45 PM
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UserRegisterEvent
 * @package App\Event
 */
class UserRegisterEvent extends Event
{

    const NAME = 'user.register';
    
    /**
     * @var User
     */
    private $registeredUser;

    public function __construct(User $registeredUser)
    {

        $this->registeredUser = $registeredUser;
    }

    /**
     * @return User
     */
    public function getRegisteredUser()
    {
        return $this->registeredUser;
    }
}