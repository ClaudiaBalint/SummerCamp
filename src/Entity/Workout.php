<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'workouts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?tipe $tipe = null;

    #[ORM\ManyToOne(inversedBy: 'workouts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\OneToMany(mappedBy: 'workout', targetEntity: ExercisesLog::class, orphanRemoval: true)]
    private Collection $exercisesLogs;

    public function __construct()
    {
        $this->exercisesLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTipe(): ?tipe
    {
        return $this->tipe;
    }

    public function setTipe(?tipe $tipe): static
    {
        $this->tipe = $tipe;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ExercisesLog>
     */
    public function getExercisesLogs(): Collection
    {
        return $this->exercisesLogs;
    }

    public function addExercisesLog(ExercisesLog $exercisesLog): static
    {
        if (!$this->exercisesLogs->contains($exercisesLog)) {
            $this->exercisesLogs->add($exercisesLog);
            $exercisesLog->setWorkout($this);
        }

        return $this;
    }

    public function removeExercisesLog(ExercisesLog $exercisesLog): static
    {
        if ($this->exercisesLogs->removeElement($exercisesLog)) {
            // set the owning side to null (unless already changed)
            if ($exercisesLog->getWorkout() === $this) {
                $exercisesLog->setWorkout(null);
            }
        }

        return $this;
    }
}
