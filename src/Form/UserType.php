<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => new Length(
                    min: 3,
                    max: 100,
                    minMessage: 'Le nom {{ value }} est trop court !',
                    maxMessage: 'Le nom {{ value }} est trop long !'
                )
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom'
            ])
            ->add('phone', TelType::class, [
                'label'    => 'Votre numéro de téléphone',
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse mail'
            ])
            ->add('password', RepeatedType::class, [
                'type'            => PasswordType::class,
                'invalid_message' => 'Le mot de passe et sa confirmation ne correspondent pas !',
                'first_options'   => [
                    'label' => 'Votre mot de passe'
                ],
                'second_options'  => [
                    'label' => 'Confirmez votre mot de passe'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => User::class,
                               ]);
    }
}
