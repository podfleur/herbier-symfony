<?php

namespace App\Controller;

use App\Entity\Releve;
use App\Form\ReleveType;
use App\Repository\ReleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/releve')]
class ReleveController extends AbstractController
{
    #[Route('/', name: 'app_releve_index', methods: ['GET'])]
    public function index(ReleveRepository $releveRepository): Response
    {
        return $this->render('releve/index.html.twig', [
            'releves' => $releveRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_releve_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $releve = new Releve();
        $form = $this->createForm(ReleveType::class, $releve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($releve);
            $entityManager->flush();

            return $this->redirectToRoute('app_releve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('releve/new.html.twig', [
            'releve' => $releve,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_releve_show', methods: ['GET'])]
    public function show(Releve $releve): Response
    {
        return $this->render('releve/show.html.twig', [
            'releve' => $releve,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_releve_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Releve $releve, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReleveType::class, $releve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_releve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('releve/edit.html.twig', [
            'releve' => $releve,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_releve_delete', methods: ['POST'])]
    public function delete(Request $request, Releve $releve, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$releve->getId(), $request->request->get('_token'))) {
            $entityManager->remove($releve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_releve_index', [], Response::HTTP_SEE_OTHER);
    }
}
