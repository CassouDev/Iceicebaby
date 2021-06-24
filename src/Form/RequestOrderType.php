<?php

namespace App\Form;

use App\Entity\FactoryOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RequestOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('factoryFirstname', TextType::class, [
                'label' => 'Prénom :'
            ])
            ->add('factoryLastname', TextType::class, [
                'label' => 'Nom :'
            ])
            ->add('factoryMail', EmailType::class, [
                'label' => 'Email :'
            ])
            ->add('factoryDeadline', DateType::class, [
                'label' => 'Date de livraison souhaitée :',
                'widget' => 'single_text'
            ])
            ->add('factoryRequest', TextareaType::class, [
                'label' => 'Ma demande :'
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
