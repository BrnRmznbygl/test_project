<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'Title',
            ])
            ->add('localisation', TextType::class, [
                'required' => false,
                'label' => 'Location',
            ])
            ->add('Technologie', ChoiceType::class, [
                'required' => false,
                'label' => 'Technologies',
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
            ])
            ->add('experienceLevel', ChoiceType::class, [
                'required' => false,
                'label' => 'Experience Level',
                'choices' => [
                    'Débutant' => 1,
                    'Intermédiaire' => 2,
                    'Expérimenté' => 3,
                    'Expert' => 4,
                    'Maître' => 5,
                ],
            ])
            ->add('minSalary', RangeType::class, [
                'required' => false,
                'label' => 'Minimum Salary',
                'attr' => [
                    'class' => 'custom-range',
                    'min' => 0,
                    'max' => 25000,
                    'step' => 250,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}