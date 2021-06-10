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

        $glaces = $repo->findByProductType("glace");
        $sorbets = $repo->findByProductType("sorbet");
        $icesticks = $repo->findByProductType("ice-stick");
        $cones = $repo->findByProductType("cone");

        return $this->render('iceicebaby/icecream.html.twig', [
            'controller_name' => 'IceicebabyController',
            'title1' => "GLACES",
            'title2' => "SORBETS",
            'title3' => "ICE STICKS",
            'title4' => "CÔNES",
            'glaces' => $glaces,
            'sorbets' => $sorbets,
            'icesticks' => $icesticks,
            'cones' => $cones
        ]);
    }

    /**
    * @Route("/icedessert", name="icedessert")
    */
    public function icedessert(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $buches = $repo->findByProductType("buche");
        $entremets = $repo->findByProductType("ice-entremet");

        return $this->render('iceicebaby/icedessert.html.twig', [
            'controller_name' => 'IceicebabyController',
            'title1' => "BÛCHES",
            'title2' => "ICE ENTREMETS",
            'buches' => $buches,
            'entremets' => $entremets
        ]);
    }

    /**
    * @Route("/{id}", name="product_sheet")
    */
    public function productsheet($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        return $this->render('iceicebaby/productsheet.html.twig', [
            'controller_name' => 'IceicebabyController',
            'product' => $product
        ]);
    }
}
