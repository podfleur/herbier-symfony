<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Releve;
use App\Form\ReleveType;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]

    public function index(EntityManagerInterface $doctrine, Request $request): Response
    { 
        $releves = $doctrine->getRepository(Releve::class)->findAll();

        $releve = new Releve();
        $form = $this->createForm(ReleveType::class, $releve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->persist($releve);
            $doctrine->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'releves' => $releves,
            'form' => $form->createView(),
        ]);
    }
}

        