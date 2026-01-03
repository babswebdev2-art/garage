<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\User;
use App\Entity\Brand;
use App\Entity\Image;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        // 1. Création de l'ADMIN
        $admin = new User();
        $admin->setFirstName('Admin')
            ->setLastName('Garage')
            ->setEmail("admin@garage.com")
            ->setIntroduction($faker->sentence())
            ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>')
            ->setPassword($this->passwordHasher->hashPassword($admin,'password'))
            ->setRoles(['ROLE_ADMIN'])
            ->setPicture("https://randomuser.me/api/portraits/men/1.jpg");

        $manager->persist($admin);

        // 2. Création des MARQUES
        $brands = [];
        $brandNames = ['Audi', 'BMW', 'Mercedes', 'Peugeot', 'Renault', 'Volkswagen', 'Toyota'];
        foreach ($brandNames as $name) {
            $brand = new Brand();
            $brand->setNom($name);
            $manager->persist($brand);
            $brands[] = $brand;
        }

        // 3. Création des USERS additionnels
        $users = [$admin];
        for($u = 1; $u <= 5; $u++) {
            $user = new User();
            $user->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(2)).'</p>')
                ->setPassword($this->passwordHasher->hashPassword($user,'password'))
                ->setPicture("https://randomuser.me/api/portraits/men/".$u.".jpg");

            $manager->persist($user);
            $users[] = $user;
        }

        // 4. Création des annonces
        for($i = 1; $i <= 30; $i++) {
            $ad = new Ad();

            // Definition des variables
            $brand = $faker->randomElement($brands);
            $title = $brand->getNom() . " " . $faker->words(2, true);
            $coverImage = "https://picsum.photos/id/".($i+20)."/1000/600";

            $ad->setTitle($title)
                ->setModel($faker->word())
                ->setCoverImage($coverImage)
                ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(4)).'</p>')
                ->setPrice(rand(5000, 50000))
                ->setKm(rand(5000, 200000))
                ->setAnnee(rand(2015, 2024))
                ->setNbProprietaires(rand(1, 3))
                ->setCylindree(rand(12, 30) / 10 . " L")
                ->setPuissance(rand(90, 400))
                ->setCarburant($faker->randomElement(['Essence', 'Diesel', 'Hybride', 'Electrique']))
                ->setTransmission($faker->randomElement(['Manuelle', 'Automatique']))
                ->setOptions("GPS, Sièges chauffants, Caméra de recul, Aide au stationnement")
                ->setAuthor($faker->randomElement($users))
                ->setBrand($brand);

            // Galerie d'images secondaires
            for($j = 1; $j <= rand(2, 4); $j++) {
                $image = new Image();
                $image->setUrl("https://picsum.photos/id/".rand(1,100)."/800/600")
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
