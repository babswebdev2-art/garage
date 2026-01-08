<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\User;
use App\Entity\Image;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    private $slugger;

    public function __construct(UserPasswordHasherInterface $hasher, SluggerInterface $slugger)
    {
        $this->hasher = $hasher;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // 1. Création de l'Admin
        $admin = new User();
        $admin->setFirstName('Babs')
            ->setLastName('Sane')
            ->setEmail('admin@garage.com')
            ->setSlug($this->slugger->slug('Babs Sane')->lower())
            ->setIntroduction($faker->sentence())
            ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
            ->setRoles(['ROLE_ADMIN'])
            ->setPicture('https://randomuser.me/api/portraits/men/1.jpg')
            ->setPassword($this->hasher->hashPassword($admin, 'password'));

        $manager->persist($admin);

        // 2. Création des Voitures
        $brands = ['Audi', 'BMW', 'Mercedes', 'Peugeot', 'Renault', 'Volkswagen', 'Tesla'];
        $fuels = ['Essence', 'Diesel', 'Hybride', 'Électrique'];
        $transmissions = ['Manuelle', 'Automatique'];

        for ($i = 1; $i <= 10; $i++) {
            $ad = new Ad();
            $brand = $faker->randomElement($brands);
            $model = $faker->word();
            $title = "$brand $model";

            $ad->setBrand($brand)
                ->setModel($model)
                ->setTitle($title)
                ->setPrice(mt_rand(8000, 60000))
                ->setKilometers(mt_rand(5000, 180000))
                ->setCoverImage("https://loremflickr.com/600/400/car?lock=" . $i)
                ->setDescription($faker->paragraph(5))
                ->setOwners(mt_rand(1, 3))
                ->setDisplacement(mt_rand(12, 30) / 10 . " L")
                ->setPower(mt_rand(90, 450))
                ->setFuel($faker->randomElement($fuels))
                ->setYear(mt_rand(2015, 2024))
                ->setTransmission($faker->randomElement($transmissions))
                ->setOptions("Climatisation, GPS, Bluetooth")
                ->setAuthor($admin);

            $manager->persist($ad);

            for ($j = 1; $j <= 3; $j++) {
                $image = new Image();
                $image->setUrl("https://loremflickr.com/600/400/car?lock=" . ($i * 10 + $j))
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);
            }
        }

        $manager->flush();
    }
}
