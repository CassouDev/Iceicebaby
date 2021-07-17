<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Entity\FactoryOrder;
use App\Entity\ProductOrder;
use App\Form\FactoryOrderType;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(CartService $cartService) 
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $orderRepo = $this->getDoctrine()->getRepository(Order::class);
 
        $ordersInProgress = $orderRepo->findBy(['orderStatus' => 'En attente de validation']); 
        $ordersOk = $orderRepo->findBy(['orderStatus' => 'Commande prête']);
        $ordersPast = $orderRepo->findBy(['orderStatus' => 'Commande réceptionnée']);
        $ordersCanceled = $orderRepo->findBy(['orderStatus' => 'Commande annulée']);

        return $this->render('admin/admin.html.twig', [
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
            'ordersInProgress' => $ordersInProgress,
            'ordersOk' => $ordersOk,
            'ordersPast' => $ordersPast,
            'ordersCanceled' => $ordersCanceled
        ]);
    }

    /**
     * @Route("/admin/{id}/{orderId}/{status}", name="admin_order_details")
     */
    public function adminOrderDetails(int $id, $status, int $orderId, Request $request, CartService $cartService, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
            default:
                throw $this->createNotFoundException(
                    'Le status \"'.$status.'\"de la commande n\'est pas bon'
                );
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

        return $this->render('admin/adminOrderDetails.html.twig', [
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
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

    /**
     * @Route("/admin/{orderId}/edit", name="admin_order_edit")
     */
    public function orderEdit(int $orderId, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $orderRepo = $this->getDoctrine()->getRepository(Order::class);

        $order = $orderRepo->find($orderId);

        if (!$order) {
            throw $this->createNotFoundException(
                'No product found for orderId '.$orderId
            );
        }

        $order->setOrderStatus();
        $manager->flush();

        return $this->redirectToRoute('admin', ['id' => $order->getId()]);
    }

    /**
     * @Route("/admin/icefactory", name="admin_icefactory")
     */
    public function adminIceFactoryOrders(CartService $cartService)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $factoryRepo = $this->getDoctrine()->getRepository(FactoryOrder::class);

        $factoryOrders = $factoryRepo->findAll();
        $factoryOrdersWaiting = $factoryRepo->findBy(['factoryStatus' => 'En attente de validation']);
        $factoryOrdersOk = $factoryRepo->findBy(['factoryStatus' => 'Commande prête']);
        $factoryOrdersPast = $factoryRepo->findBy(['factoryStatus' => 'Commande réceptionnée']);
        $factoryOrdersCanceled = $factoryRepo->findBy(['factoryStatus' => 'Commande annulée']);

        return $this->render('admin/adminFactoryOrders.html.twig', [
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'admin_orders_link' => "",
            'admin_factory_link' => "clicked_link",
            'factoryOrders' => $factoryOrders,
            'factoryOrdersWaiting' => $factoryOrdersWaiting,
            'factoryOrdersOk' => $factoryOrdersOk,
            'factoryOrdersPast' => $factoryOrdersPast,
            'factoryOrdersCanceled' => $factoryOrdersCanceled,
        ]);
    }

    /**
     * @Route("/admin/icefactory{factoryOrderId}/{status}", name="admin_icefactory_details")
     */
    public function adminFactoryDetails(int $factoryOrderId, $status, Request $request, CartService $cartService,  EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $factoryRepo = $this->getDoctrine()->getRepository(FactoryOrder::class);

        $factoryOrder = $factoryRepo->find($factoryOrderId);
        
        $form = $this->createForm(FactoryOrderType::class, $factoryOrder);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // No $manager->persist because the order already is in the db
            $manager->flush();

            return $this->redirectToRoute('admin_icefactory');
        }
        
        switch ($status) {
            case 'progress':
                $factoryOrdersWaiting = $factoryRepo->findBy(['factoryStatus' => 'En attente de validation']);
                $factoryOrdersOk = null;
                $factoryOrdersPast = null;
                $factoryOrdersCanceled = null;
            break;
            case 'ok':
                $factoryOrdersWaiting = null;
                $factoryOrdersOk = $factoryRepo->findBy(['factoryStatus' => 'Commande prête']);
                $factoryOrdersPast = null;
                $factoryOrdersCanceled = null;
            break;
            case 'past':
                $factoryOrdersWaiting = null;
                $factoryOrdersOk = null;
                $factoryOrdersPast = $factoryRepo->findBy(['factoryStatus' => 'Commande réceptionnée']);
                $factoryOrdersCanceled = null;
            break;
            case 'canceled':
                $factoryOrdersWaiting = null;
                $factoryOrdersOk = null;
                $factoryOrdersPast = null;
                $factoryOrdersCanceled = $factoryRepo->findBy(['factoryStatus' => 'Commande annulée']);
            break;
            default: 
                throw $this->createNotFoundException(
                    'Le status \"'.$status.'\"de la commande n\'est pas bon'
                );
        }

        return $this->render('admin/adminFactoryDetails.html.twig', [
            'items' => $cartService->getFullCart(),
            'quantity' => $cartService->getQuantity(),
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'admin_orders_link' => "",
            'admin_factory_link' => "clicked_link",
            'factoryOrder' => $factoryOrder,
            'factoryOrdersWaiting' => $factoryOrdersWaiting,
            'factoryOrdersOk' => $factoryOrdersOk,
            'factoryOrdersPast' => $factoryOrdersPast,
            'factoryOrdersCanceled' => $factoryOrdersCanceled,
            'form_updateOrder' => $form->createView()
        ]);
    }
}