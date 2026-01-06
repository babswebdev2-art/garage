<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * Page « Vente » – Affiche toutes les voitures du showroom
     * Informations : Marque, Modèle, Image, KM, Prix
     */
    #[Route('/ads', name: 'ads_index')]
    public function index(AdRepository $repo): Response
    {
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Page de détails d'une voiture avec galerie d'images
     * Utilise le MapEntity pour lier automatiquement le slug de l'URL à l'objet Ad
     */
    #[Route('/ads/{slug}', name: 'ads_show')]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad
    ): Response {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
