<?php

namespace App\Form;

use App\Entity\PasswordUpdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => "Ancien mot de passe",
                'attr' => [
                    'placeholder' => "Tapez votre mot de passe actuel..."
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => "Nouveau mot de passe",
                'attr' => [
                    'placeholder' => "Choisissez un nouveau mot de passe..."
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => "Confirmation du nouveau mot de passe",
                'attr' => [
                    'placeholder' => "Confirmez votre nouveau mot de passe..."
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PasswordUpdate::class,
        ]);
    }
}
