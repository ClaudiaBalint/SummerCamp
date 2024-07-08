<?php

namespace App\Controller;

use App\Entity\Tipe;
use App\Form\Type\TipeType;
use App\Repository\TipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TipeController extends AbstractController
{
    #[Route('/tipes', name: 'tipe_list', methods: ['GET'])]
    public function index(TipeRepository $tipeRepository): Response
    {
        $tipe = $tipeRepository->findAll();

        return $this->render('tipe/index.html.twig', [
            'tipes' => $tipe,
        ]);
    }

    #[Route('/tipe/{id}/show', name: 'tipe_show', methods: ['GET'])]
    public function show(int $id, TipeRepository $tipeRepository): Response
    {
        $tipe = $tipeRepository->find($id);

        if (!$tipe) {
            throw $this->createNotFoundException('No type found for id ' . $id);
        }

        return $this->render('tipe/showTipePage.html.twig', [
            'tipe' => $tipe,
        ]);
    }

    #[Route('/tipe/new', name: 'tipe_new', methods: (array('GET', 'POST')))]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $tipe = new Tipe();
        $form = $this->createForm(TipeType::class, $tipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tipe = $form->getData();
            $entityManager->persist($tipe);
            $entityManager->flush();

            return $this->redirectToRoute('tipe_list');

        }

        return $this->render('tipe/addTipePage.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/tipe/{id}/edit', name: 'tipe_edit', methods: ['GET', 'PATCH', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $tipe = $entityManager->getRepository(Tipe::class)->find($id);

        if (!$tipe) {
            throw $this->createNotFoundException('No type found for id ' . $id);
        }

        $form = $this->createForm(TipeType::class, $tipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tipe_list');
        }

        return $this->render('tipe/editTipePage.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tipe/{id}/delete', name: 'tipe_delete', methods: ['GET','POST','DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager, TipeRepository $tipeRepository): Response
    {
        $tipe = $tipeRepository->findOneById($id);

        if (!$tipe) {
            throw $this->createNotFoundException('No type found for id ' . $id);
        }

        $entityManager->remove($tipe);
        $entityManager->flush();

        return $this->redirectToRoute('tipe_list');
    }

}