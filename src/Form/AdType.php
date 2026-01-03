<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Brand;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'nom',
                'label' => 'Marque',
                'placeholder' => 'Sélectionnez la marque du véhicule'
            ])
            ->add('title', TextType::class, $this->getConfig('Titre', 'Modèle et version (ex: Golf 8 GTE)'))

            ->add('model', TextType::class, $this->getConfig('Modèle précis', 'Ex: Phase 2 Hybrid Rechargeable'))

            ->add('coverImage', UrlType::class, $this->getConfig('Image de couverture', 'URL de l\'image principale'))

            ->add('description', TextareaType::class, $this->getConfig('Description détaillée', 'Historique, entretien et détails du véhicule'))

            ->add('price', MoneyType::class, $this->getConfig('Prix de vente', 'Indiquez le prix du véhicule'))

            ->add('km', IntegerType::class, $this->getConfig('Kilométrage', 'Nombre de kilomètres au compteur'))

            ->add('annee', IntegerType::class, $this->getConfig('Année', 'Année de mise en circulation'))

            ->add('carburant', ChoiceType::class, $this->getConfig('Carburant', '', [
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'Hybride' => 'Hybride',
                    'Électrique' => 'Électrique'
                ]
            ]))

            ->add('transmission', ChoiceType::class, $this->getConfig('Boîte de vitesse', '', [
                'choices' => [
                    'Manuelle' => 'Manuelle',
                    'Automatique' => 'Automatique'
                ]
            ]))

            ->add('puissance', IntegerType::class, $this->getConfig('Puissance (ch)', 'Puissance réelle en chevaux'))

            ->add('cylindree', TextType::class, $this->getConfig('Cylindrée', 'Ex: 2.0 L ou 1995 cm3'))

            ->add('nbProprietaires', IntegerType::class, $this->getConfig('Nombre de propriétaires', 'Nombre de mains précédentes'))

            ->add('options', TextareaType::class, $this->getConfig('Options du véhicule', 'Listez les options (ex: Toit ouvrant, GPS...)'))

            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
