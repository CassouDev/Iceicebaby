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
    * @Route("/icedessert", name="icedessert")
    */
    public function icedessert(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $products = $repo->findByProductType("Type de produit glace/sorbet/ice stick/bûche/ice entremet");

        return $this->render('iceicebaby/icedessert.html.twig', [
            'controller_name' => 'IceicebabyController',
            'title1' => "BÛCHES",
            'title2' => "ICE ENTREMETS",
            'products' => $products
        ]);
    }

    /**
    * @Route("/productsheet/{id}", name="product_sheet")
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
