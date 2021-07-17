<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('orderDate')
            // ->add('orderPrice')
            ->add('orderStatus', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'En attente de validation',
                    'Commande prête' => 'Commande prête',
                    'Commande réceptionnée' => 'Commande réceptionnée',
                    'Cammande annulée' => 'Commande annulée',
                ]
            ])
            // ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
