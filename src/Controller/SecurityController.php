<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Form\RegistrationType;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/{status}/inscription", name="security_registration")
     * @Route("/account/{id}/edit", name="account_edit")
     */
    public function userInfos($status = null, User $user = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, CartService $cartService)
    {
        if (!$user) { //if there is no id in the ur
            $user = new User();
        }

        $form = $this->createForm(RegistrationType::class, $user); //call the form

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            $manager->persist($user);
            $manager->flush();

            if ($status == 'panier') {
                return $this->redirectToRoute('security_login', ['status' => $status]);
            } else {
                return $this->redirectToRoute('security_login', ['status' => 'security']);
            }
        }
        
        // ORDERING OR NOT
        if ($status == 'panier') {
            $cartService->ordering();
        }else {
            $cartService->notOrdering();
        }

        return $this->render('security/registration.html.twig', [
            'status' => $status,
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'ordering' => $cartService->getOrderStatus(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'panier_link' => "",
            'connexion_link' => "clicked_link",
            'recap_link' => "",
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{status}/login", name="security_login")
     */
    public function login($status, CartService $cartService) 
    {
        if ($status == 'panier') {
            $cartService->ordering();
        }else if ($status == 'security'){
            $cartService->notOrdering();
        }

        // var_dump($cartService->getOrderStatus());

        return $this->render('security/login.html.twig', [
            'status' => $status,
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'ordering' => $cartService->getOrderStatus(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'panier_link' => "",
            'connexion_link' => "clicked_link",
            'recap_link' => ""
        ]);
    }
    
    /**
     * @Route("/deconnection", name="security_logout")
     */
    public function logout() {}

    /**
     * @Route("/account/{id}", name="account")
     */
    public function showAccount($id, CartService $cartService) 
    {
        $repo = $this->getDoctrine()->getRepository(User::class);

        $user = $repo->find($id);

        return $this->render('security/account.html.twig', [
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'infos_link' => "clicked_link",
            'commandes_link' => "",
            'user' => $user
        ]);
    }

    /**
     * @Route("/account/{id}/orders", name="account_orders")
     */
    public function accountOrders($id, CartService $cartService) {
        $userRepo = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepo->find($id);

        $orderRepo = $this->getDoctrine()->getRepository(Order::class);

        $ordersInProgress = $orderRepo->findBy(['orderStatus' => 'En attente de validation']);
        $ordersPast = $orderRepo->findBy(['orderStatus' => 'Commande réceptionnée']);

        return $this->render('security/accountOrders.html.twig', [
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'infos_link' => "",
            'commandes_link' => "clicked_link",
            'user' => $user,
            'ordersInProgress' => $ordersInProgress,
            'ordersPast' => $ordersPast
        ]);
    }

    /**
     * @Route("/account/{id}/{orderId}/{status}", name="oder_details")
     */
    public function orderDetails($id, $status, $orderId, CartService $cartService)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepo->find($id);

        $orderRepo = $this->getDoctrine()->getRepository(Order::class);

        $order = $orderRepo->find($orderId);

        if ($status == 'progress') {
            $ordersInProgress = $orderRepo->findBy(['orderStatus' => 'En attente de validation']);
            $ordersPast = null;
        } elseif ($status == 'past') {
            $ordersPast = $orderRepo->findBy(['orderStatus' => 'Commande réceptionnée']);
            $ordersInProgress = null;
        }
        
        $productORepo = $this->getDoctrine()->getRepository(ProductOrder::class);

        $productOrders = $productORepo->findBy(['order' => $order->getId()]);

        $productRepo = $this->getDoctrine()->getRepository(Product::class);
        
        foreach ($productOrders as $productOrder) {
            $product = $productRepo->findBy(['id' => $productOrder->getProduct()]);
        }

        return $this->render('security/orderDetails.html.twig', [
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'infos_link' => "",
            'commandes_link' => "clicked_link",
            'user' => $user,
            'status' => $status,
            'order' => $order,
            'productOrders' => $productOrders,
            'product' => $product,
            'ordersInProgress' => $ordersInProgress,
            'ordersPast' => $ordersPast
        ]);
    }
}