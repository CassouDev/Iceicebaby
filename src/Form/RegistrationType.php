<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName', TextType::class)
            ->add('userLastname', TextType::class)
            ->add('userMail', EmailType::class)
            ->add('userPhoneNumber', TelType::class)
            ->add('password', PasswordType::class)
            ->add('confirmPassword', PasswordType::class)
            ->add('userAdress', TextType::class)
            ->add('userCity', TextType::class)
            ->add('userPostcode')
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'Utilisateur' => 'ROLE_USER',
            //         'Administrateur' => 'ROLE_ADMIN'
            //     ],
            //     'expanded' => true,
            //     'multiple' => true
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
