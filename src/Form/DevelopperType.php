<?php

namespace App\Form;

use App\Entity\Developper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                    'C#' => 'csharp',
                    'Swift' => 'swift',
                    'Go' => 'go',
                    'Kotlin' => 'kotlin',
                    'Rust' => 'rust',
                    'TypeScript' => 'typescript',
                    'Scala' => 'scala',
                    'R' => 'r',
                    'Objective-C' => 'objc',
                    'Perl' => 'perl',
                    'Shell' => 'shell',
                    'HTML' => 'html',
                    'CSS' => 'css',
                    'SQL' => 'sql',
                    'Bash' => 'bash',
                    'PowerShell' => 'powershell',
                    'Assembly' => 'assembly'
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
            ->add('avatarUrl', FileType::class, [
                'label' => 'Avatar (Image file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Assert\Image([
                        'maxSize' => '5M',
                    ]),
                ],
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => 'Profile Visibility',
                'required' => false,
                'mapped' => false,
                'data' => $builder->getData()->getUserDevelopper()->isPublic(),
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
