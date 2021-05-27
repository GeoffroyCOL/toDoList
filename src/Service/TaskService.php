<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TaskRepository $repository
    ){}
    
    /**
     * @param  Task $task
     * @return void
     */
    public function persist(Task $task): void
    {
        $this->manager->persist($task);
        $this->manager->flush();
    }
}