<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\ProductOrder;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     */
    public function index(CartService $cartService): Response 
    {
        return $this->render('cart/cart.html.twig', [
            'total' => $cartService->getTotal(),
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'ordering' => $cartService->getOrderStatus(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'panier_link' => "clicked_link",
            'connexion_link' => "",
            'recap_link' => ""
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService) 
    {
        $cartService->add($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);

        return $this->redirectToRoute('cart');
    }
    
    /**
     * @Route("/panier/recap/{id}", name="cart_recap")
     */
    public function recapCart($id, CartService $cartService) {
        $repo = $this->getDoctrine()->getRepository(User::class);

        $user = $repo->find($id);

        $cartService->notOrdering();
        // var_dump($cartService->getOrderStatus());

        return $this->render('cart/cartRecap.html.twig', [
            'total' => $cartService->getTotal(),
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'ordering' => false,
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'panier_link' => "",
            'connexion_link' => "",
            'recap_link' => "clicked_link",
            'user' => $user
        ]);
    }

    public function orderCart($id, CartService $cartService)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->find($id);

        // $productRepo = $this->getDoctrine

        $cartService->notOrdering(); //'ordering' = false

        $newOrder = new Order(); //create an order in the bdd

        $newOrder->setOderDate(new \DateTime());
        $newOrder->setOrderPrice($cartService->getTotal());
        $newOrder->setOrderStatus('Commande en attente de validation');
        $newOrder->setUser($user);

        $productId = $cartService->getProductId();

        foreach ($productId as $product) {
            $newProductOrder = new ProductOrder();

            $newProductOrder->setQuantity($cartService->getQuantity());
            $newProductOrder->setOrder($newOrder->getId());
            $newProductOrder->setProduct($productId);
        }

        
    }
}
