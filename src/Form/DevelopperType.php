<?php

namespace App\Form;

use App\Entity\Developper;
use App\Entity\Entreprise;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('languages', ChoiceType::class, [
                'choices' => [
                    'PHP' => 'php',
                    'JavaScript' => 'javascript',
                    'Python' => 'python',
                    'Java' => 'java',
                    'C++' => 'cpp',
                    'Ruby' => 'ruby',
                ],
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developper::class,
        ]);
    }
}
