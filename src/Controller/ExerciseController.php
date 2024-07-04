<?php

namespace App\Controller;

use App\Entity\Exercises;
use App\Entity\Tipe;
use App\Form\Type\ExerciseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ExercisesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ExerciseController extends AbstractController
{
    #[Route('/exercises', name: 'exercise_list', methods: ['GET'])]
    public function index(ExercisesRepository $exercisesRepository): Response
    {
        $exercises = $exercisesRepository->findAll();

        return $this->render('exercise/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/exercise/new', name: 'exercise_new', methods: (array('GET', 'POST')))]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $exercise = new Exercises();
        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->redirectToRoute('exercise_list');

        }

        return $this->render('exercise/addExercisePage.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/exercise/{id}/edit', name: 'exercise_edit', methods: ['GET', 'PATCH', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercise = $entityManager->getRepository(Exercises::class)->find($id);

        if (!$exercise) {
            throw $this->createNotFoundException('No exercise found for id ' . $id);
        }

        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('exercise_list');
        }

        return $this->render('exercise/editExercisePage.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/exercise/{id}/delete', name: 'exercise_delete', methods: ['GET','POST','DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager, ExercisesRepository $exercisesRepository): Response
    {
        $exercise = $exercisesRepository->findOneById($id);

        if (!$exercise) {
            throw $this->createNotFoundException('No exercise found for id ' . $id);
        }

        $entityManager->remove($exercise);
        $entityManager->flush();

        return $this->redirectToRoute('exercise_list');
    }

}