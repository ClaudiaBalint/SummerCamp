<?php

namespace App\Form\Type;

use App\Entity\Exercises;
use App\Entity\ExercisesLog;
use App\Entity\Workout;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExercisesLogType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nr_reps', IntegerType::class)
            ->add('weight', IntegerType::class)
            ->add('time', TimeType::class)
//            ->add('workout', EntityType::class, [
//                'class' => Workout::class,
//                'choice_label' => 'name',
//                'placeholder' => 'Choose a workout',
//            ])
            ->add('exercises', EntityType::class, [
                'class' => Exercises::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an exercise',
            ])
            ->add('save', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExercisesLog::class,
        ]);
    }

}