<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connection", name="security_login")
     */
    public function login() {
        return $this->render('security/login.html.twig', [
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
        ]);
    }
    
    /**
     * @Route("/deconnection", name="security_logout")
     */
    public function logout() {}

    /**
     * @Route("/account/{id}", name="account")
     */
    public function showAccount($id) {
        $repo = $this->getDoctrine()->getRepository(User::class);

        $user = $repo->find($id);

        return $this->render('security/account.html.twig', [
            'icecream_link' => "",
            'icedessert_link' => "",
            'icefactory_link' => "",
            'iceboutique_link' => "",
            'link_1' => "clicked_link",
            'link_2' => "",
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