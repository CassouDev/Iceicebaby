<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IceicebabyController extends AbstractController
{
    /**
    * @Route("/iceicebaby", name="iceicebaby")
    */
    public function index(): Response
    {
        return $this->render('iceicebaby/index.html.twig', [
            'controller_name' => 'IceicebabyController',
            'title1' => "GLACES",
            'title2' => "SORBETS",
            'title3' => "ICE STICKS",
            'title4' => "CORNETS"
        ]);
    }

    /**
    * @Route("/", name="home")
    */
    public function home() {
        return $this->render('iceicebaby/home.html.twig', [
            'title1' => "ICE CREAM",
            'title2' => "ICE DESSERT",
            'title3' => "NOS ICE & VOUS"
        ]);
    }
}
