<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('back/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
