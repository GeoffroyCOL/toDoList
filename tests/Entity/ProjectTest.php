<?php

namespace Tests\Entity;

use App\Entity\Project;
use App\Repository\UserRepository;

class ProjectTest extends ElementTest
{
    protected function getEntity()
    {
        $project = new Project;

        self::bootkernel();
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByUsername('username'); 

        $project->setName("Le projet todolist")
            ->setDescription("Un projet pour faire des liste de tâche à réaliser")
            ->setCreatedBy($user)
            ->setStatus('en cours')
        ;

        return $project;
    }
}