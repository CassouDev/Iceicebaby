<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\FactoryOrder;
use App\Form\RequestOrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IceicebabyController extends AbstractController
{
    // HOME

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

    // ICE CREAM

    /**
    * @Route("/icecream", name="icecream")
    */
    public function icecream(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $glaces = $repo->findBy(['productType' => "glace"]);
        $sorbets = $repo->findBy(['productType' => "sorbet"]);
        $icesticks = $repo->findBy(['productType' => "icestick"]);
        $cones = $repo->findBy(['productType' => "cone"]);

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
    * @Route("/product/{type}/{id}", name="productsheet")
    */
    public function Productsheet($type, $id)
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->find($id);

        switch($type) {
            case 'glace':
                return $this->render('iceicebaby/icecreamProduct.html.twig', [
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
                break;
            case 'sorbet':
                return $this->render('iceicebaby/icecreamProduct.html.twig', [
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
                break;
            case 'ice-stick':
                return $this->render('iceicebaby/icecreamProduct.html.twig', [
                            'icecream_link' => "clicked_link",
                            'icedessert_link' => "",
                            'icefactory_link' => "",
                            'iceboutique_link' => "",
                            'glaces_link'=>"",
                            'sorbets_link'=>"",
                            'icesticks_link'=>"clicked_link",
                            'cones_link'=>"",
                            'product' => $product,
                        ]);
                    break;
                case 'cone':
                    return $this->render('iceicebaby/icecreamProduct.html.twig', [
                        'icecream_link' => "clicked_link",
                        'icedessert_link' => "",
                        'icefactory_link' => "",
                        'iceboutique_link' => "",
                        'glaces_link'=>"",
                        'sorbets_link'=>"",
                        'icesticks_link'=>"",
                        'cones_link'=>"clicked_link",
                        'product' => $product,
                    ]);
                    break;
                case 'buche':
                    return $this->render('iceicebaby/icedessertProduct.html.twig', [
                        'icecream_link' => "",
                        'icedessert_link' => "clicked_link",
                        'icefactory_link' => "",
                        'iceboutique_link' => "",
                        'buches_link'=>"clicked_link",
                        'entremets_link'=>"",
                        'product' => $product,
                    ]);
                    break;
                case 'ice-entremet':
                    return $this->render('iceicebaby/icedessertProduct.html.twig', [
                        'icecream_link' => "",
                        'icedessert_link' => "clicked_link",
                        'icefactory_link' => "",
                        'iceboutique_link' => "",
                        'buches_link'=>"",
                        'entremets_link'=>"clicked_link",
                        'product' => $product,
                    ]);
                    break;
        }
    }
    
    // ICE DESSERT

    /**
    * @Route("/icedessert", name="icedessert")
    */
    public function icedessert(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $buches = $repo->findBy(['productType' => "buche"]);
        $entremets = $repo->findBy(['productType' => "ice-entremet"]);

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

    // ICE FACTORY

     /**
    *  @Route("/icefactory", name="icefactory")
    */
    public function icefactory(Request $request, EntityManagerInterface $manager): Response
    {
        $factoryOrder = new FactoryOrder();

        $form = $this->createForm(RequestOrderType::class, $factoryOrder);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $factoryOrder->setFactoryDate(new \DateTime());
            $factoryOrder->setFactoryStatus("Demande en attente de validation");
            // dd($factoryOrder);

            $manager->persist($factoryOrder);
            $manager->flush();

            return $this->redirectToRoute('icefactory');
        }

        return $this->render('iceicebaby/icefactory.html.twig',[
            'controller_name' => 'IceicebabyController',
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "clicked_link",
            'iceboutique_link' => "",
            'form_factoryOrder' => $form->createView()
        ]);
    }

    // ICE BOUTIQUE
    
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
