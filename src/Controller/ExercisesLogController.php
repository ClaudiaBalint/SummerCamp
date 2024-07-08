<?php

namespace App\Controller;

use App\Entity\ExercisesLog;
use App\Form\Type\ExercisesLogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ExercisesLogRepository;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ExercisesLogController extends AbstractController
{
    #[Route('/exerciseslogs', name: 'exerciseslog_list', methods: ['GET'])]
    public function index(ExercisesLogRepository $exerciseslogRepository): Response
    {
        $exerciselog = $exerciseslogRepository->findAll();

        return $this->render('exercisesLog/index.html.twig', [
            'exerciseslog' => $exerciselog,
        ]);
    }

    #[Route('/exerciseslog/{id}/show', name: 'exerciseslog_show', methods: ['GET'])]
    public function show(int $id, ExercisesLogRepository $exerciseslogRepository): Response
    {
        $exerciselog = $exerciseslogRepository->find($id);

        if (!$exerciselog) {
            throw $this->createNotFoundException('No exercise_log found for id ' . $id);
        }

        return $this->render('exercisesLog/showExercisesLogPage.html.twig', [
            'exerciseslog' => $exerciselog,
        ]);
    }

//    #[Route('/exerciseslog/new/{workout_id}', name: 'exerciseslog_new', methods: ['GET', 'POST'])]
//    public function new(int $workout_id, Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $exerciselog = new ExercisesLog();
//        $exerciselog->setWorkoutId($workout_id);
//
//        $form = $this->createForm(ExercisesLogType::class, $exerciselog);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($exerciselog);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('exerciseslog_list');
//        }
//
//        return $this->render('exercisesLog/addExercisesLogPage.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }

    #[Route('/exerciseslog/new', name: 'exerciseslog_new', methods: (array('GET', 'POST')))]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $exerciselog = new ExercisesLog();

        $form = $this->createForm(ExercisesLogType::class, $exerciselog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exerciselog = $form->getData();
            $entityManager->persist($exerciselog);
            $entityManager->flush();

            return $this->redirectToRoute('exerciseslog_list');

        }

        return $this->render('exercisesLog/addExercisesLogPage.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/exerciseslog/{id}/edit', name: 'exerciseslog_edit', methods: ['GET', 'PATCH', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $exerciselog = $entityManager->getRepository(ExercisesLog::class)->find($id);

        if (!$exerciselog) {
            throw $this->createNotFoundException('No exercise_log found for id ' . $id);
        }

        $form = $this->createForm(ExercisesLogType::class, $exerciselog);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('exerciseslog_list');
        }

        return $this->render('exercisesLog/editExercisesLogPage.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/exerciseslog/{id}/delete', name: 'exerciseslog_delete', methods: ['GET','POST','DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager, ExercisesLogRepository $exerciseslogRepository): Response
    {
        $exerciselog = $exerciseslogRepository->findOneById($id);

        if (!$exerciselog) {
            throw $this->createNotFoundException('No exercise_log found for id ' . $id);
        }

        $entityManager->remove($exerciselog);
        $entityManager->flush();

        return $this->redirectToRoute('exerciseslog_list');
    }
}