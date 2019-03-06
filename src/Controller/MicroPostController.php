<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use App\Entity\MicroPost;
use App\Form\MicroPostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * @Route("/micro-post")
 */
class MicroPostController 
{
	
	/**
	* @var \Twig_Environment
	*/
	private $twig;


	/**
	* @var MicroPostRepository
	*/
	private $microPostRepository;


	/**
	* @var FormFactoryInterface
	*/
	private $formFactory;


	/**
	* @var EntityManagerInterface
	*/
	private $entityManager;


	/**
	* @var RouterInterface
	*/
	private $router;


	function __construct(
		\Twig_Environment $twig, 
		MicroPostRepository $microPostRepository,
		FormFactoryInterface $formFactory,
		EntityManagerInterface $entityManager,
		RouterInterface $router
	)
	{
		$this->twig = $twig;
		$this->microPostRepository = $microPostRepository;
		$this->formFactory = $formFactory;
		$this->entityManager = $entityManager;
		$this->router = $router;
	}
	/**
	* @Route("/", name="micro_post_index")
	*/
	public function index()
	{
		$html = $this->twig->render('micro-post/index.html.twig',[
			'posts' => $this->microPostRepository->findBy([], ['time' => 'DESC']),
		]);

		return new Response($html);
	}


	/**
	* @Route("/edit/{id}", name="micro_post_edit")
	*/
	public function edit(MicroPost $microPost, Request $request)
	{
		
		$form = $this->formFactory->create(MicroPostType::class, $microPost);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($microPost);
			$this->entityManager->flush();

			return new RedirectResponse($this->router->generate('micro_post_index'));
		}

		return new Response(
			$this->twig->render('micro-post/add.html.twig', [
				'form' => $form->createView()
		])
		);
	}
	/**
	* @Route("/delete/{id}", name="micro_post_delete")
	*/
	public function delete(MicroPost $microPost)
	{
		$this->entityManager->remove($microPost);
		$this->entityManager->flush();

		return new RedirectResponse($this->router->generate('micro_post_index'));
	}

	/**
	* @Route("/add", name="micro_post_add")
	*/
	public function add(Request $request)
	{
		$microPost = new MicroPost();
		$microPost->setTime(new \DateTime());

		$form = $this->formFactory->create(MicroPostType::class, $microPost);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($microPost);
			$this->entityManager->flush();

			return new RedirectResponse($this->router->generate('micro_post_index'));
		}

		return new Response(
			$this->twig->render('micro-post/add.html.twig', [
				'form' => $form->createView()
		])
		);
	}


	/**
	* @Route("/{id}", name="micro_post_post")
	*/
	public function post(MicroPost $post)
	{
		// $post = $this->microPostRepository->find($id);

		return new Response($this->twig->render('micro-post/post.html.twig', 
			[
			'post' => $post
			]));
	}

	
}