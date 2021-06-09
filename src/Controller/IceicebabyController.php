<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class IceicebabyController extends AbstractController
{
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

    /**
    * @Route("/icecream", name="icecream")
    */
    public function icecream(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $products = $repo->findByProductType("Type de produit glace/sorbet/ice stick/bûche/ice entremet");

        return $this->render('iceicebaby/icecream.html.twig', [
            'controller_name' => 'IceicebabyController',
            'title1' => "GLACES",
            'title2' => "SORBETS",
            'title3' => "ICE STICKS",
            'title4' => "CÔNES",
            'products' => $products
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
