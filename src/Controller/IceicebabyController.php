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
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
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
            'icecream_link' => "clicked_link",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'glaces_link'=>"clicked_link",
            'sorbets_link'=>"",
            'icesticks_link'=>"",
            'cones_link'=>"",
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
            'icecream_link' => "",
            'icedessert_link' => "clicked_link",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'buches_link'=>"clicked_link",
            'entremets_link'=>"",
            'title1' => "BÛCHES",
            'title2' => "ICE ENTREMETS",
            'buches' => $buches,
            'entremets' => $entremets
        ]);
    }

    /**
    * @Route("/icecream-product-glace-{id}", name="icecream_product_glace")
    */
    public function icecreamProductGlace($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        return $this->render('iceicebaby/icecreamProduct.html.twig', [
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "clicked_link",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'glaces_link'=>"clicked_link",
            'sorbets_link'=>"",
            'icesticks_link'=>"",
            'cones_link'=>"",
            'product' => $product
        ]);
    }

     /**
    * @Route("/icecream-product-sorbet-{id}", name="icecream_product_sorbet")
    */
    public function icecreamProductSorbet($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        return $this->render('iceicebaby/icecreamProduct.html.twig', [
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "clicked_link",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'glaces_link'=>"",
            'sorbets_link'=>"clicked_link",
            'icesticks_link'=>"",
            'cones_link'=>"",
            'product' => $product
        ]);
    }

     /**
    * @Route("/icecream-product-icestick-{id}", name="icecream_product_icestick")
    */
    public function icecreamProductIcestick($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        return $this->render('iceicebaby/icecreamProduct.html.twig', [
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "clicked_link",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'glaces_link'=>"",
            'sorbets_link'=>"",
            'icesticks_link'=>"clicked_link",
            'cones_link'=>"",
            'product' => $product
        ]);
    }

     /**
    * @Route("/icecream-product-cone-{id}", name="icecream_product_cone")
    */
    public function icecreamProductCone($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        return $this->render('iceicebaby/icecreamProduct.html.twig', [
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "clicked_link",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'glaces_link'=>"",
            'sorbets_link'=>"",
            'icesticks_link'=>"",
            'cones_link'=>"clicked_link",
            'product' => $product
        ]);
    }

     /**
    * @Route("/icedessert-product-buche-{id}", name="icedessert_product_buche")
    */
    public function icedessertProductBuche($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        return $this->render('iceicebaby/icedessertProduct.html.twig', [
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "",
            'icedessert_link' => "clicked_link",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'buches_link'=>"clicked_link",
            'entremets_link'=>"",
            'product' => $product
        ]);
    }

     /**
    * @Route("/icedessert-iceentremet-{id}", name="icedessert_product_iceentremet")
    */
    public function icedessertProductEntremet($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        return $this->render('iceicebaby/icedessertProduct.html.twig', [
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "",
            'icedessert_link' => "clicked_link",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'buches_link'=>"",
            'entremets_link'=>"clicked_link",
            'product' => $product
        ]);
    }

     /**
    *  @Route("/icefactory", name="icefactory")
    */
    public function icefactory(): Response
    {
        return $this->render('iceicebaby/icefactory.html.twig',[
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "clicked_link",
            'iceboutique_link' => ""
        ]);
    }

     /**
    *  @Route("/iceboutique", name="iceboutique")
    */
    public function iceboutique(): Response
    {
        return $this->render('iceicebaby/iceboutique.html.twig',[
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "clicked_link"
        ]);
    }

}
