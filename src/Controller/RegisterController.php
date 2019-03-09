<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/9/19
 * Time: 9:54 AM
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends AbstractController
{

    /**
     * @var RouterInterface
     */
    private $routerInterface;

    /**
     * RegisterController constructor.
     * @param RouterInterface $routerInterface
     */
    function __construct(RouterInterface $routerInterface)
    {
        $this->routerInterface = $routerInterface;
    }


    /**
     * @Route("/register", name="user_register")
     */
    public function register(UserPasswordEncoderInterface $passwordEncoderInterface, Request $request)
    {
        $user = new User();
        $form = $this->createForm(
            UserType::class,
            $user
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoderInterface->encodePassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return new RedirectResponse($this->routerInterface->generate('micro_post_index'));


        }

        return $this->render('register/register.html.twig', [
            'form' => $form->createView()
        ]);

    }
}