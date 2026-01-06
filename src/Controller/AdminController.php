<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class AdminController extends AbstractController
{
    /**
     * CRÉER une annonce (Point 5 du cahier des charges)
     */
    #[Route('/admin/ads/new', name: 'admin_ads_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On lie l'utilisateur connecté à l'annonce (Auteur)
            $ad->setAuthor($this->getUser());

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "L'annonce pour la <strong>{$ad->getBrand()}</strong> a bien été créée !");
            return $this->redirectToRoute('ads_show', ['slug' => $ad->getSlug()]);
        }

        return $this->render('admin/ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * MODIFIER une annonce (Point 6 du cahier des charges)
     */
    #[Route('/admin/ads/{id}/edit', name: 'admin_ads_edit')]
    public function edit(Ad $ad, Request $request, EntityManagerInterface $manager): Response
    {
        // Sécurité : Seul l'auteur ou un admin peut modifier l'objet Ad
        if ($ad->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', "Vous n'avez pas les droits pour modifier cette annonce.");
            return $this->redirectToRoute('ads_index');
        }

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Pour une modification, l'objet est déjà "persisté", flush() suffit
            $manager->flush();

            $this->addFlash('success', "Les modifications de l'annonce <strong>{$ad->getBrand()}</strong> ont été enregistrées !");
            return $this->redirectToRoute('ads_show', ['slug' => $ad->getSlug()]);
        }

        // Le chemin correspond à l'arborescence templates/admin/ad/edit.html.twig
        return $this->render('admin/ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }

    /**
     * SUPPRIMER une annonce (Point 6 du cahier des charges)
     */
    #[Route('/admin/ads/{id}/delete', name: 'admin_ads_delete')]
    public function delete(Ad $ad, EntityManagerInterface $manager): Response
    {
        // Vérification de sécurité avant suppression
        if ($ad->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('ads_index');
        }

        $manager->remove($ad);
        $manager->flush();

        $this->addFlash('success', "L'annonce a été supprimée avec succès.");
        return $this->redirectToRoute('ads_index');
    }
}
