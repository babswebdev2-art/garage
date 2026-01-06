<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['label' => "Prénom"])
            ->add('lastName', TextType::class, ['label' => "Nom"])
            ->add('email', EmailType::class, ['label' => "Adresse Email"])
            ->add('picture', UrlType::class, ['label' => "Photo de profil (URL)"])
            ->add('introduction', TextType::class, ['label' => "Présentation courte"])
            ->add('description', TextareaType::class, ['label' => "Description détaillée", 'attr' => ['rows' => 5]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
