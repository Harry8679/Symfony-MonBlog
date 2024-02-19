<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First name',
                'constraints' => new Length(20, 3),
                'attr' => [
                    'placeholder' => 'Please, add your first name'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last name',
                'constraints' => new Length(20, 2),
                'attr' => [
                    'placeholder' => 'Please, add your last name'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => new Length(30, 8),
                'attr' => [
                    'placeholder' => 'Please add your email address'
                ]
            ])
            // ->add('roles')
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'constraints' => new Length(20, 3),
                'attr' => [
                    'placeholder' => 'Please add your password'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Register'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
