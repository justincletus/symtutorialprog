<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * 
 */
class ExampleVoter implements VoterInterface
{
	
	// function __construct(argument)
	// {
	// 	# code...
	// }

	public function vote(TokenInterface $token, $subject, array $attributes)
	{
		# code...
	}
}