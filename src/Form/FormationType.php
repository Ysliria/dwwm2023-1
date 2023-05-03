<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la formation',
                'attr'  => [
                    'placeholder' => 'Concepteur Développeur d\'Application'
                ]
            ])
            ->add('code', TextType::class, [
                'label' => 'Code de la formation',
                'attr'  => [
                    'placeholder' => 'CDA'
                ]
            ])
            ->add('startedAt', DateTimeType::class, [
                'label' => 'Date de début de la formation',
                'input' => 'datetime_immutable',
                'widget' => 'single_text'
            ])
            ->add('finishedAt', DateTimeType::class, [
                'label' => 'Date de fin de la formation',
                'input' => 'datetime_immutable',
                'help'  => 'La date de fin doit être postérieur à la date de début',
                'widget' => 'single_text'
            ])
            ->add('ville', TextType::class, [
                'label' => 'Lieu de la formation',
                'attr'  => [
                    'placeholder' => 'Tours'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Formation::class,
            ]
        );
    }
}
