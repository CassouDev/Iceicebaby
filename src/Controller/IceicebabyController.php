<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\FactoryOrder;
use App\Form\RequestOrderType;
use App\Service\Cart\CartService;
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
    public function home(CartService $cartService) 
    {
        $repo = $this->getDoctrine()->getRepository(User::class);

        $users = $repo->findAll();

        return $this->render('iceicebaby/home.html.twig', [
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'title1' => "ICE CREAM",
            'title2' => "ICE DESSERT",
            'title3' => "NOS ICE & VOUS",
            'users' => $users,
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'ordering' => $cartService->getOrderStatus()
        ]);
    }

    // ICE CREAM

    /**
    * @Route("/icecream", name="icecream")
    */
    public function icecream(CartService $cartService): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $glaces = $repo->findBy(['productType' => "glace"]);
        $sorbets = $repo->findBy(['productType' => "sorbet"]);
        $icesticks = $repo->findBy(['productType' => "ice-stick"]);
        $cones = $repo->findBy(['productType' => "cone"]);

        return $this->render('iceicebaby/icecream.html.twig', [
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
            'cones' => $cones,
            'quantity' => $cartService->getQuantity(),
            'items' => $cartService->getFullCart()
        ]);
    }
    
     /**
    * @Route("/product/{type}/{id}", name="productsheet")
    */
    public function Productsheet($type, $id, CartService $cartService, Request $request, EntityManagerInterface $manager)
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
                    'product' => $product,
                    'ordering' => $cartService->getOrderStatus(),
                    'quantity' => $cartService->getQuantity(),
                    'total' => $cartService->getTotal(),
                    'items' => $cartService->getFullCart()
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
                    'product' => $product,
                    'ordering' => $cartService->getOrderStatus(),
                    'quantity' => $cartService->getQuantity(),
                    'total' => $cartService->getTotal(),
                    'items' => $cartService->getFullCart()
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
                        'ordering' => $cartService->getOrderStatus(),
                        'quantity' => $cartService->getQuantity(),
                        'total' => $cartService->getTotal(),
                        'items' => $cartService->getFullCart()
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
                    'ordering' => $cartService->getOrderStatus(),
                    'quantity' => $cartService->getQuantity(),
                    'total' => $cartService->getTotal(),
                    'items' => $cartService->getFullCart()
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
                    'ordering' => $cartService->getOrderStatus(),
                    'quantity' => $cartService->getQuantity(),
                    'total' => $cartService->getTotal(),
                    'items' => $cartService->getFullCart()
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
                    'ordering' => $cartService->getOrderStatus(),
                    'quantity' => $cartService->getQuantity(),
                    'total' => $cartService->getTotal(),
                    'items' => $cartService->getFullCart()
                ]);
            break;
            default:
                throw $this->createNotFoundException(
                    'Le typ de produit \"'.$type.'\"de la commande n\'existe pas'
                );
        }
    }
    
    // ICE DESSERT

    /**
    * @Route("/icedessert", name="icedessert")
    */
    public function icedessert(CartService $cartService): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $buches = $repo->findBy(['productType' => "buche"]);
        $entremets = $repo->findBy(['productType' => "ice-entremet"]);

        return $this->render('iceicebaby/icedessert.html.twig', [
            'icecream_link' => "",
            'icedessert_link' => "clicked_link",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'buches_link'=>"clicked_link",
            'entremets_link'=>"",
            'title1' => "BÛCHES",
            'title2' => "ICE ENTREMETS",
            'buches' => $buches,
            'entremets' => $entremets,
            'quantity' => $cartService->getQuantity(),
            'items' => $cartService->getFullCart()
        ]);
    }

    // ICE FACTORY

     /**
    *  @Route("/icefactory", name="icefactory")
    */
    public function icefactory(Request $request, EntityManagerInterface $manager, CartService $cartService): Response
    {
        $factoryOrder = new FactoryOrder();

        $form = $this->createForm(RequestOrderType::class, $factoryOrder);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $factoryOrder->setFactoryDate(new \DateTime());
            $factoryOrder->setFactoryStatus("En attente de validation");
            // dd($factoryOrder);

            $manager->persist($factoryOrder);
            $manager->flush();

            return $this->redirectToRoute('icefactory');
        }

        return $this->render('iceicebaby/icefactory.html.twig',[
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "clicked_link",
            'iceboutique_link' => "",
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'form_factoryOrder' => $form->createView()
        ]);
    }

    // ICE BOUTIQUE
    
     /**
    *  @Route("/iceboutique", name="iceboutique")
    */
    public function iceboutique(CartService $cartService): Response
    {
        return $this->render('iceicebaby/iceboutique.html.twig',[
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "clicked_link",
            'quantity' => $cartService->getQuantity(),
            'items' => $cartService->getFullCart()
        ]);
    }
}
