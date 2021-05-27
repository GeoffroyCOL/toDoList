<?php

namespace Tests\Entity;

use App\Entity\Task;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;

class TaskTest extends ElementTest
{
    protected function getEntity()
    {
        $task = new Task;

        self::bootkernel();
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByUsername('username');

        $project = static::$container->get(ProjectRepository::class)->find(1);

        $task->setName("Le projet todolist")
            ->setDescription("Un projet pour faire des liste de tâche à réaliser")
            ->setCreatedBy($user)
            ->setStatus('en cours')
            ->setProject($project)
        ;

        return $task;
    }
    
    /**
     * @return void
     */
    public function testNotBlankProject(): void
    {
        $task = $this->getEntity();
        $task->setProject(null);

        $this->assertHasErrors($task, 1);
    }
}
