<?php


namespace App\Controller;

use App\Services\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     *
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(Chart $chart):Response
    {
        return $this->render('Backend\Dashboard\dashboard.html.twig', ['nbrArticle' => $chart->nbrArticle()]);
    }
}