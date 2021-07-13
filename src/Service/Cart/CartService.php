<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;

    protected $productRepository;

    protected $orderingIce;

    public function __construct(SessionInterface $session, ProductRepository $productRepository) {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->orderingIce = false;
    }

    public function add(int $id) {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function remove(int $id) {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    public function getFullCart() : array 
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $panierWithData;
    }

    public function getTotal() : float 
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getProductPrice() * $item['quantity'];
        }

        return $total;
    }

    public function getQuantity()
    {
        $cartQuantity = 0;

        foreach ($this->getFullCart() as $item) {
            $cartQuantity += $item['quantity'];
        }

        return $cartQuantity;
    }

    public function getProductId()
    {
        foreach ($this->getFullCart() as $item) {
            $productId = $item['id'];
        }

        return $productId;
    }

    public function getOrderStatus()
    {
        $this->orderingIce = $this->session->get('orderingIce');
        
        return $this->orderingIce;
    }

    public function ordering()
    {
        $orderingIce = $this->session->get('orderingIce', false);

        $orderingIce = true;

        $this->session->set('orderingIce', $orderingIce);
    }

    public function notOrdering()
    {
        $orderingIce = $this->session->get('orderingIce', false);

        $orderingIce = false;

        $this->session->set('orderingIce', $orderingIce);
    }

    public function clearCart()
    {
        $this->session->set('panier', []);
    }
}