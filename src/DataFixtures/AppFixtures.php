<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\MicroPost;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AppFixtures extends Fixture
{
    private const USERS = [
    [
        'username' => 'john_deo',
        'email' => 'john_deo@doe.com',
        'password' => 'john123',
        'fullName' => 'John Deo',
        'roles' =>[User::ROLE_USER]
    ],
    [
        'username' => 'john_britto',
        'email' => 'john_britto@doe.com',
        'password' => 'john123',
        'fullName' => 'John Britto',
        'roles' =>[User::ROLE_USER]
    ],
    [
        'username' => 'john',
        'email' => 'john@doe.com',
        'password' => 'john123',
        'fullName' => 'John Ditto',
        'roles' =>[User::ROLE_USER]
    ],
    [
        'username' => 'super_admin',
        'email' => 'super_admin@admin.com',
        'password' => 'admin1234',
        'fullName' => 'Micro Admin',
        'roles' =>[User::ROLE_ADMIN]
    ],
    ];


    private const POST_TEXT = [
        'Hello, how are you',
        'It\'s a good day',
        'Where are you from',
        'How is your job.',
        'whats a good news today.'
    ];

    /**
    * @var UserPasswordEncoderInterface
    */
    private $passwordEncoder;

	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;

	}

    public function load(ObjectManager $manager)
    {
		$this->loadUsers($manager);
		$this->loadMicroPosts($manager);
    }

    private function loadMicroPosts(ObjectManager $manager)
    {
    	for ($i=0; $i < 10; $i++) { 
        	$microPost = new MicroPost();
        	$microPost->setText(
                self::POST_TEXT[rand(0, count(self::POST_TEXT) - 1)]
            );
            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) .' day');

        	$microPost->setTime($date);

			$microPost->setUser($this->getReference(
                self::USERS[rand(0, count(self::USERS) - 1)]['username']
            ));
        	$manager->persist($microPost);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
    	foreach (self::USERS as $userData){
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setFullName($userData['fullName']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $userData['password']));
            $user->setRoles($userData['roles']);
            $user->getEnabled(true);

            $this->addReference($userData['username'], $user);
            $manager->persist($user);
            $manager->flush();
        }

    }
}
