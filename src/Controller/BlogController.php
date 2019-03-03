<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * BlogController class
 */
class BlogController 
{
	/**
	* @var Greeting
	*/
	private $greeting;

	/**
	* @var Twig_Environment
	*/
	private $twig;

	function __construct(Greeting $greeting, \Twig_Environment $twig)
	{
		$this->greeting = $greeting;
		$this->twig 	= $twig;

	}

	/**
	* @Route("/{name}", name="blog_index")
	*/
	public function index($name)
	{
		$html = $this->twig->render('base.html.twig', ['message' => $this->greeting->greet($name)]);

		return new Response($html);
	}
}