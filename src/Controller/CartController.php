<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/{status}/panier", name="cart")
     */
    public function index($status, CartService $cartService)
    {
        switch ($status) {
            case 'glace':
            case 'sorbet':
            case 'ice-stick':
            case 'cone':
                return $this->redirectToRoute('icecream');
            break;
            case 'buche':
            case 'ice-entremet':
                return $this->redirectToRoute('icedessert');
            break;
            case 'ordering':            
                return $this->render('cart/cart.html.twig', [
                    'status' => $status,
                    'total' => $cartService->getTotal(),
                    'items' => $cartService->getFullCart(),
                    'quantity' => $cartService->getQuantity(),
                    'ordering' => $cartService->getOrderStatus(),
                    'cartMessage' => 'Votre panier est vide, remplissez le !!',
                    'icecream_link' => "",
                    'icedessert_link' => "",
                    'icefactory_link' => "",
                    'iceboutique_link' => "",
                    'panier_link' => "clicked_link",
                    'connexion_link' => "",
                    'recap_link' => ""
                ]);
            break;
            case 'ok':
                $cartService-> clearCart();

                return $this->render('cart/cart.html.twig', [
                    'status' => $status,
                    'total' => $cartService->getTotal(),
                    'items' => $cartService->getFullCart(),
                    'quantity' => $cartService->getQuantity(),
                    'ordering' => $cartService->getOrderStatus(),
                    'cartMessage' => "Votre commande a bien été passée. Retrouvez la dans votre compte, rubrique 'MES COMMANDES'.",
                    'icecream_link' => "",
                    'icedessert_link' => "",
                    'icefactory_link' => "",
                    'iceboutique_link' => "",
                    'panier_link' => "clicked_link",
                    'connexion_link' => "",
                    'recap_link' => ""
                ]);
            break;
        }
    }

    /**
     * @Route("/panier/add/{type}/{id}", name="cart_add")
     */
    public function add($type, $id, CartService $cartService) 
    {
        $cartService->add($id);

        return $this->redirectToRoute('cart', ['status' => $type]);
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

    /**
     *  @Route("/panier/cart-order/{id}", name="cart_order")
     */
    public function orderCart(int $id, CartService $cartService, EntityManagerInterface $manager)
    {
        $cartService->notOrdering(); //'ordering' = false

        //create a new order in the bdd
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $userId = $userRepo->find($id);

        $newOrder = new Order();

        $newOrder->setOrderDate(new \DateTime());
        $newOrder->setOrderPrice($cartService->getTotal());
        $newOrder->setOrderStatus('En attente de validation');
        $newOrder->setUser($userId);

        $manager->persist($newOrder);
        $manager->flush();

        // Create a new porductOrder in bdd for each product of the order
        $productRepo = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepo->findBy(['id' => $cartService->getProductId()]);
      
        foreach ($products as $product) {
            $newProductOrder = new ProductOrder();

            $newProductOrder->setOrder($newOrder);
            $newProductOrder->setQuantity($cartService->getEachQuantity($id));
            $newProductOrder->setProduct($product);
            $manager->persist($newProductOrder);
            $manager->flush();
        }

        return $this->redirectToRoute('cart', ['status' => 'ok']);
    }
}
