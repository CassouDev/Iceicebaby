<?php

namespace App\Form;

use App\Entity\FactoryOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FactoryOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('factoryFirstname')
            // ->add('factoryLastname')
            // ->add('factoryMail')
            // ->add('factoryDate')
            // ->add('factoryDeadline')
            // ->add('factoryRequest')
            ->add('factoryStatus', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'En attente de validation',
                    'Commande prête' => 'Commande prête',
                    'Commande réceptionnée' => 'Commande réceptionnée',
                    'Cammande annulée' => 'Commande annulée',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FactoryOrder::class,
        ]);
    }
}
