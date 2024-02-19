<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'constraints' => new Length(50, 2),
                'attr' => [
                    'placeholder' => 'Please, add a title'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Content',
                'attr' => [
                    'placeholder' => 'Please, add a content'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
            ])
            // ->add('createdAt')
//             ->add('user', EntityType::class, [
//                 'class' => User::class,
// 'choice_label' => 'id',
//             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
