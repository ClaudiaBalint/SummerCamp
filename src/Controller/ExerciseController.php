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
    #[Route('/exercises', name: 'exercise_list')]
    public function index(ExercisesRepository $exercisesRepository): Response
    {
        $exercises = $exercisesRepository->findAll();

        return $this->render('exercise/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/1', methods: (array('GET', 'POST')))]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $exercise = new Exercises();
        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();
            $tipe = new Tipe();
            $tipe->setName('sdf');
            $exercise->setTipe($tipe);
            $entityManager->persist($tipe);
            $entityManager->persist($exercise);
            $entityManager->flush();

        }

        return $this->render('exercise/addExercisePage.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}