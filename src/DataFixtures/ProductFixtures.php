<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=01; $i <25 ; $i++) { 
            $product = new Product();
            $product->setProductName("Nom du produit n°$i")
                    ->setProductType("Type de produit glace/sorbet/ice stick/bûche/ice entremet")
                    ->setProductDescription("Description du produit n°$i")
                    ->setProductQuantity("5")
                    ->setProductPrice("10")
                    ->setProductMainPicture("home_icecream_icesticks.jpg")
                    ->setProductPicture2("colorful-ice-cream.jpg");

            $manager->persist($product);
        }

        $manager->flush();
    }
}
