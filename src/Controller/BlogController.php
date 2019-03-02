<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Greeting;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * BlogController class
 */
class BlogController extends AbstractController
{
	/**
	* @var Greeting
	*/
	private $greeting;

	function __construct(Greeting $greeting)
	{
		$this->greeting = $greeting;

	}

	/**
	* @Route("/", name="blog_index")
	*/
	public function index(Request $request)
	{
		return $this->render('base.html.twig', ['message' => $this->greeting->greet($request->get('name'))]);
	}
}