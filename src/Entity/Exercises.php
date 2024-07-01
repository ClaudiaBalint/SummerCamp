<?php

namespace App\Entity;

use App\Repository\ExercisesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExercisesRepository::class)]
class Exercises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $video_link = null;

    #[ORM\ManyToOne(inversedBy: 'exercises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tipe $tipe = null;

    #[ORM\OneToMany(mappedBy: 'exercises', targetEntity: ExercisesLog::class, orphanRemoval: true)]
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

    public function getVideoLink(): ?string
    {
        return $this->video_link;
    }

    public function setVideoLink(?string $video_link): static
    {
        $this->video_link = $video_link;

        return $this;
    }

    public function getTipe(): ?Tipe
    {
        return $this->tipe;
    }

    public function setTipe(?Tipe $tipe): static
    {
        $this->tipe = $tipe;

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
            $exercisesLog->setExercises($this);
        }

        return $this;
    }

    public function removeExercisesLog(ExercisesLog $exercisesLog): static
    {
        if ($this->exercisesLogs->removeElement($exercisesLog)) {
            // set the owning side to null (unless already changed)
            if ($exercisesLog->getExercises() === $this) {
                $exercisesLog->setExercises(null);
            }
        }

        return $this;
    }
}
