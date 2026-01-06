<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class, ['label' => 'Marque', 'attr' => ['placeholder' => 'Ex: Audi']])
            ->add('model', TextType::class, ['label' => 'Modèle', 'attr' => ['placeholder' => 'Ex: A3']])
            ->add('title', TextType::class, ['label' => 'Titre de l\'annonce'])
            ->add('price', MoneyType::class, ['label' => 'Prix'])
            ->add('km', IntegerType::class, ['label' => 'Kilométrage'])
            ->add('coverImage', UrlType::class, ['label' => 'URL de l\'image de couverture'])
            ->add('description', TextareaType::class, ['label' => 'Description détaillée'])
            ->add('year', IntegerType::class, ['label' => 'Année de mise en circulation'])
            ->add('fuel', TextType::class, ['label' => 'Carburant'])
            ->add('power', IntegerType::class, ['label' => 'Puissance (ch)'])
            ->add('engine', TextType::class, ['label' => 'Cylindrée'])
            ->add('transmission', TextType::class, ['label' => 'Transmission'])
            ->add('owners', IntegerType::class, ['label' => 'Nombre de propriétaires'])
            ->add('options', TextareaType::class, ['label' => 'Options (texte)'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
