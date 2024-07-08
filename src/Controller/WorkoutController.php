<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Workout;
use App\Form\Type\WorkoutType;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{

    #[Route('/workouts', name: 'workout_list', methods: ['GET'])]
    public function index(WorkoutRepository $workoutRepository): Response
    {
        $workout = $workoutRepository->findAll();

        return $this->render('workout/index.html.twig', [
            'workouts' => $workout,
        ]);
    }

    #[Route('/workout/{id}/show', name: 'workout_show', methods: ['GET'])]
    public function show(int $id, WorkoutRepository $workoutRepository): Response
    {
        $workout = $workoutRepository->find($id);

        if (!$workout) {
            throw $this->createNotFoundException('No workout found for id ' . $id);
        }

        return $this->render('workout/showWorkoutPage.html.twig', [
            'workout' => $workout,
        ]);
    }

    #[Route('/workout/new', name: 'workout_new', methods: (array('GET', 'POST')))]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $workout = new Workout();

//        $defaultUser = $entityManager->getRepository(User::class)->find(1);
//        if ($defaultUser) {
//            $workout->setUser($defaultUser);
//        }

        $form = $this->createForm(WorkoutType::class, $workout);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $workout = $form->getData();
            $entityManager->persist($workout);
            $entityManager->flush();

            return $this->redirectToRoute('workout_list');

        }

        return $this->render('workout/addWorkoutPage.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/workout/{id}/edit', name: 'workout_edit', methods: ['GET', 'PATCH', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $workout = $entityManager->getRepository(Workout::class)->find($id);

        if (!$workout) {
            throw $this->createNotFoundException('No workout found for id ' . $id);
        }

        $form = $this->createForm(WorkoutType::class, $workout);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('workout_list');
        }

        return $this->render('workout/editWorkoutPage.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/workout/{id}/delete', name: 'workout_delete', methods: ['GET','POST','DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager, WorkoutRepository $workoutRepository): Response
    {
        $workout = $workoutRepository->findOneById($id);

        if (!$workout) {
            throw $this->createNotFoundException('No workout found for id ' . $id);
        }

        $entityManager->remove($workout);
        $entityManager->flush();

        return $this->redirectToRoute('workout_list');
    }

}