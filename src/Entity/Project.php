<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project extends Element
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class)
     */
    protected $tasks;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTasks(): ?Task
    {
        return $this->tasks;
    }

    public function setTasks(?Task $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }
}
