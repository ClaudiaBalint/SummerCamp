<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ExercisesRepository;
use Symfony\Component\Routing\Annotation\Route;

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
}