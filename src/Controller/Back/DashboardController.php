<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * DashboardController
 * @Security("is_granted('ROLE_ADMIN_LIST')", statusCode=403, message="Vous ne pouvez pas accéder à cette zone")
 */
class DashboardController extends AbstractController
{    
    /**
     * @return Response
     */
    #[Route('/admin/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('back/dashboard/index.html.twig', [
            'controller_name'   => 'DashboardController',
            'current_page'      => 'dashboard',
            'component'         => 'admin'
        ]);
    }
}
