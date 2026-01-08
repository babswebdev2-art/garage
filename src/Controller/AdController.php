<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdController extends AbstractController
{
    /**
     * Affiche la liste de toutes les annonces
     */
    #[Route('/ads', name: 'ads_index')]
    public function index(AdRepository $repo): Response
    {
        return $this->render('ad/index.html.twig', [
            'ads' => $repo->findAll()
        ]);
    }

    /**
     * Permet de créer une annonce
     */
    #[Route('/ads/new', name: 'ads_create')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ad->setAuthor($this->getUser());

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     */
    #[Route('/ads/{slug}/edit', name: 'ads_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        if ($ad->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException("Vous n'êtes pas le propriétaire de cette annonce !");
        }

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }

    /**
     * Permet de supprimer une annonce
     */
    #[Route('/ads/{slug}/delete', name: 'ads_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad,
        EntityManagerInterface $manager
    ): Response {
        if ($ad->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException("Droit de suppression refusé.");
        }

        $manager->remove($ad);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce <strong>{$ad->getTitle()}</strong> a été supprimée."
        );

        return $this->redirectToRoute('ads_index');
    }

    /**
     * Affiche une seule annonce
     */
    #[Route('/ads/{slug}', name: 'ads_show')]
    public function show(string $slug, AdRepository $repo): Response
    {
        $ad = $repo->findOneBy(['slug' => $slug]);

        if (!$ad) {
            throw $this->createNotFoundException("L'annonce n'existe pas.");
        }

        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
