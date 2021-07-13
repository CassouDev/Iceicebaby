<?php

namespace App\Controller;

use App\Entity\User;
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
     */
    public function registration($status, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, CartService $cartService)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

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
     * @Route("/account/edit/{id}", name="edit_account")
     */
    public function editAccount($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(User::class);

        $editedUser = $repo->find($id);

        // if(!$editedUser) {
        //     throw $this->createNotFoundException(
        //         'No product found for id '.$id
        //     );
        // }

        $editedUser->setAll();
        $entityManager->flush();

        return $this->redirectToRoute('account', [
            'id' => $editedUser->getId()
        ]);
    }
}