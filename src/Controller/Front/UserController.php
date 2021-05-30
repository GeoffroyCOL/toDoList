<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\User\UserRegisterType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * register
     * Allow a user to register.
     *
     * @param Request $request
     *
     * @return Response
     */
    #[Route('/inscription', name: 'user.register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $this->userService->persist($user);
            $this->addFlash('success', 'Votre inscription à bien été prise en compte.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('front/user/register.html.twig', [
            'form'          => $form->createView(),
            'current_page'  => 'inscription'
        ]);
    }
}
