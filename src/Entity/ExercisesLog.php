<?php

namespace App\Entity;

use App\Repository\ExercisesLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExercisesLogRepository::class)]
class ExercisesLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nr_reps = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\ManyToOne(inversedBy: 'exercisesLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?workout $workout = null;

    #[ORM\ManyToOne(inversedBy: 'exercisesLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?exercises $exercises = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNrReps(): ?int
    {
        return $this->nr_reps;
    }

    public function setNrReps(int $nr_reps): static
    {
        $this->nr_reps = $nr_reps;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getWorkout(): ?workout
    {
        return $this->workout;
    }

    public function setWorkout(?workout $workout): static
    {
        $this->workout = $workout;

        return $this;
    }

    public function getExercises(): ?exercises
    {
        return $this->exercises;
    }

    public function setExercises(?exercises $exercises): static
    {
        $this->exercises = $exercises;

        return $this;
    }
}
