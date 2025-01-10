<?php

namespace App\Form;

use App\Entity\Developper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchDevType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'First Name',
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => 'Last Name',
            ])
            ->add('Localisation', TextType::class, [
                'required' => false,
                'label' => 'Location',
            ])
            ->add('experienceLevel', ChoiceType::class, [
                'required' => false,
                'label' => 'Experience Level',
                'choices' => [
                    'Junior' => 1,
                    'Mid' => 2,
                    'Senior' => 3,
                    'Débutant' => 1,
                    'Intermédiaire' => 2,
                    'Expérimenté' => 3,
                    'Expert' => 4,
                    'Maître' => 5,
                ],
            ])
            ->add('languages', ChoiceType::class, [
                'required' => false,
                'label' => 'Languages',
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
            ->add('minSalary', NumberType::class, [
                'required' => false,
                'label' => 'Minimum Salary',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developper::class,
        ]);
    }
}