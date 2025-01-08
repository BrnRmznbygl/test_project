<?php

namespace App\Form;

use App\Entity\Developper;
use App\Entity\Entreprise;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DevelopperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('lastName', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('localisation', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('views')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('languages', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('experienceLevel')
            ->add('minSalary', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Range(['min' => 0]),
                ],
            ])
            ->add('bio')
            ->add('avatarUrl', null, [
                'constraints' => [
                    new Assert\Url(),
                ],
            ])
            ->add('UserDevelopper', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('favoriteEntreprises', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('favoritePosts', EntityType::class, [
                'class' => Post::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('favoriteDeveloppers', EntityType::class, [
                'class' => Developper::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developper::class,
        ]);
    }
}