<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['label' => "Prénom", 'attr' => ['placeholder' => "Votre prénom..."]])
            ->add('lastName', TextType::class, ['label' => "Nom", 'attr' => ['placeholder' => "Votre nom..."]])
            ->add('email', EmailType::class, ['label' => "Email", 'attr' => ['placeholder' => "votre@email.com"]])
            ->add('picture', UrlType::class, ['label' => "Photo de profil (URL)", 'attr' => ['placeholder' => "Lien vers votre photo..."]])
            ->add('password', PasswordType::class, ['label' => "Mot de passe", 'attr' => ['placeholder' => "Choisissez un mot de passe..."]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
