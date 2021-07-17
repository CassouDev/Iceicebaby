<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Entity\FactoryOrder;
use App\Entity\ProductOrder;
use App\Form\FactoryOrderType;
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
        if (!$user) { //if there is no id in the url
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
    public function orders($id = null, CartService $cartService) 
    {
        $orderRepo = $this->getDoctrine()->getRepository(Order::class);
 
        $ordersInProgress = $orderRepo->findBy(['orderStatus' => 'En attente de validation']); 
        $ordersOk = $orderRepo->findBy(['orderStatus' => 'Commande prête']);
        $ordersPast = $orderRepo->findBy(['orderStatus' => 'Commande réceptionnée']);
        $ordersCanceled = $orderRepo->findBy(['orderStatus' => 'Commande annulée']);
        
        // foreach ($ordersInProgress as $orderInProgress) {
        //     $userOrders = $orderInProgress->getUser($id);

        // }

        $userRepo = $this->getDoctrine()->getRepository(User::class);

            $user = $userRepo->find($id);
            $userOrders = $orderRepo->findBy(['user' => $id]);
            foreach ($userOrders as $userOrder) {
                $userOrderStatus = $userOrder->getOrderStatus();
            }
        
        return $this->render('security/orders.html.twig', [
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'infos_link' => "",
            'commandes_link' => "clicked_link",
            'admin_orders_link' => "clicked_link",
            'admin_factory_link' => "",
            'user' => $user,
            'userOrders' => $userOrders,
            'userOrderStatus' => $userOrderStatus,
            'ordersInProgress' => $ordersInProgress,
            'ordersOk' => $ordersOk,
            'ordersPast' => $ordersPast,
            'ordersCanceled' => $ordersCanceled
        ]);
    }

    /**
     * @Route("/account/{id}/{orderId}/{status}", name="order_details")
     */
    public function orderDetails(int $id, $status, int $orderId, Request $request, CartService $cartService, EntityManagerInterface $manager)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepo->find($id);

        $orderRepo = $this->getDoctrine()->getRepository(Order::class);

        $order = $orderRepo->find($orderId);
        // parameter of the tabs colors
        switch ($status) {
            case 'progress':
                $ordersInProgress = $orderRepo->findBy(['orderStatus' => 'En attente de validation']);
                $ordersPast = null;
                $ordersOk = null;
                $ordersCanceled = null;
            break;
            case 'ok':
                $ordersOk = $orderRepo->findBy(['orderStatus' => 'Commande prête']);
                $ordersInProgress = null;
                $ordersPast = null;
                $ordersCanceled = null;
            break;
            case 'past':
                $ordersPast = $orderRepo->findBy(['orderStatus' => 'Commande réceptionnée']);
                $ordersInProgress = null;
                $ordersOk = null;
                $ordersCanceled = null;
            break;
            case 'canceled':
                $ordersCanceled = $orderRepo->findBy(['orderStatus' => 'Commande annulée']);
                $ordersInProgress = null;
                $ordersOk = null;
                $ordersPast = null;
            break;
        }

        $productORepo = $this->getDoctrine()->getRepository(ProductOrder::class);

        $productOrders = $productORepo->findBy(['order' => $order->getId()]);

        $productRepo = $this->getDoctrine()->getRepository(Product::class);
        
        foreach ($productOrders as $productOrder) {
            $product = $productRepo->findBy(['id' => $productOrder->getProduct()]);
        }

        if(!$order) {
            $order = new Order();
        }

        $form = $this->createForm(OrderType::class, $order);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // No $manager->persist because the order already is in the db
            $manager->flush();

            return $this->redirectToRoute('admin');
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
            'admin_orders_link' => "clicked_link",
            'admin_factory_link' => "",
            'user' => $user,
            'status' => $status,
            'order' => $order,
            'productOrders' => $productOrders,
            'product' => $product,
            'ordersInProgress' => $ordersInProgress,
            'ordersOk' => $ordersOk,
            'ordersPast' => $ordersPast,
            'ordersCanceled' => $ordersCanceled,
            'form_updateOrder' => $form->createView()
        ]);
    }
}