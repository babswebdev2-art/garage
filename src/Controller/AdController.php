<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AdController extends AbstractController
{
    /**
     * Toutes les annonces (Showroom)
     */
    #[Route('/ads', name: 'ads_index')]
    public function index(AdRepository $repo): Response
    {
        return $this->render('ad/index.html.twig', [
            'ads' => $repo->findAll()
        ]);
    }

    /**
     * Création d'une annonce
     */
    #[Route('/ads/new', name: 'ads_create')]
    #[IsGranted("ROLE_USER")]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }

            $ad->setAuthor($this->getUser());
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !");

            return $this->redirectToRoute('ads_show', ['slug' => $ad->getSlug()]);
        }

        return $this->render('ad/new.html.twig', [
            'myForm' => $form->createView()
        ]);
    }

    /**
     * Édition d'une annonce
     */
    #[Route('/ads/{slug}/edit', name: "ads_edit")]
    #[IsGranted(
        attribute: new Expression('(user === subject and is_granted("ROLE_USER")) or is_granted("ROLE_ADMIN")'),
        subject: new Expression('args["ad"].getAuthor()'),
        message: "Cette annonce ne vous appartient pas."
    )]
    public function edit(Request $request, EntityManagerInterface $manager, Ad $ad): Response
    {
        $form = $this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> a été modifiée !");
            return $this->redirectToRoute('ads_show', ['slug' => $ad->getSlug()]);
        }

        return $this->render("ad/edit.html.twig", [
            'ad' => $ad,
            'myForm' => $form->createView()
        ]);
    }

    /**
     * Suppression d'une annonce
     */
    #[Route("/ads/{slug}/delete", name: "ads_delete")]
    #[IsGranted(
        attribute: new Expression('(user === subject and is_granted("ROLE_USER")) or is_granted("ROLE_ADMIN")'),
        subject: new Expression('args["ad"].getAuthor()'),
        message: "Action interdite."
    )]
    public function delete(Ad $ad, EntityManagerInterface $manager): Response
    {
        $manager->remove($ad);
        $manager->flush();

        $this->addFlash('success', "L'annonce a été supprimée.");
        return $this->redirectToRoute('ads_index');
    }

    /**
     * Détails d'une annonce
     */
    #[Route('/ads/{slug}', name: 'ads_show')]
    public function show(Ad $ad): Response
    {
        return $this->render("ad/show.html.twig", [
            "ad" => $ad
        ]);
    }
}
