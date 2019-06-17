<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     *
     * @Route("/admin", name="admin_dashboard")
     */
    public function index():Response
    {
        return $this->render('Backend\Dashboard\dashboard.html.twig');
    }
}