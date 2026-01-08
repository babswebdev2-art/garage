<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => "Titre"])
            ->add('brand', TextType::class, ['label' => "Marque"])
            ->add('model', TextType::class, ['label' => "Modèle"])
            ->add('coverImage', UrlType::class, ['label' => "Image de couverture"])
            ->add('price', MoneyType::class, ['label' => "Prix"])
            ->add('kilometers', IntegerType::class, ['label' => "Kilométrage"])
            ->add('year', IntegerType::class, ['label' => "Année"])
            ->add('owners', IntegerType::class, ['label' => "Nombre de propriétaires"])
            ->add('displacement', TextType::class, ['label' => "Cylindrée"])
            ->add('power', IntegerType::class, ['label' => "Puissance (CH)"])
            ->add('fuel', TextType::class, ['label' => "Carburant"])
            ->add('transmission', TextType::class, ['label' => "Transmission"])
            ->add('description', TextareaType::class, ['label' => "Description"])
            ->add('options', TextareaType::class, ['label' => "Options du véhicule"])

            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,    
                
                'allow_delete' => true, 
                
                'by_reference' => false /
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
