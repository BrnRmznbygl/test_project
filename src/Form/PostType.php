<?php
namespace App\Form;

use App\Entity\Entreprise;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre du poste'])
            ->add('localisation', TextType::class, ['label' => 'Localisation'])
            ->add('technologie', TextType::class, ['label' => 'Technologies recherchées'])
            ->add('experienceLevel', ChoiceType::class, [
                'choices' => [
                    'Débutant' => 1,
                    'Intermédiaire' => 2,
                    'Expérimenté' => 3,
                    'Expert' => 4,
                    'Maître' => 5,
                ],
                'label' => 'Niveau d\'expérience requis'
            ])
            ->add('salary', MoneyType::class, ['label' => 'Salaire proposé'])
            ->add('detail', TextareaType::class, ['label' => 'Description détaillée'])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'name',
                'label' => 'Entreprise'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
