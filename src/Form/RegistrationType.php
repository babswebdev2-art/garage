<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType; // Import de ta classe mère
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfig("Prénom", "Votre prénom..."))
            ->add('lastName', TextType::class, $this->getConfig("Nom", "Votre nom de famille..."))
            ->add('email', EmailType::class, $this->getConfig("Email", "Votre adresse email..."))
            ->add('picture', UrlType::class, $this->getConfig("Photo de profil", "URL de votre avatar..."))
            ->add('password', PasswordType::class, $this->getConfig("Mot de passe", "Choisissez un mot de passe robuste"))
            ->add('introduction', TextType::class, $this->getConfig("Introduction", "Présentez-vous en quelques mots..."))
            ->add('description', TextareaType::class, $this->getConfig("Description détaillée", "Présentez votre parcours en détail..."))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
