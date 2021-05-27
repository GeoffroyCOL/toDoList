<?php

namespace App\Service;

use App\Entity\Project;
use App\Entity\User;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ProjectService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private ProjectRepository $repository,
        private Security $security
    ) {}
    
    /**
     * Récupère la liste des projets d'un utilisateur
     * 
     * @param  User $user
     * @return array
     */
    public function getProjectsByUser(User $user): array
    {
        return $this->repository->findBy(['createdBy' => $user]);
    }
    
    /**
     * @param  int $id
     * @return Project|null
     */
    public function getProject(int $id): ?Project
    {
        return $this->repository->find($id);
    }
    
    /**
     * persist
     *
     * @param  Project $project
     * @return void
     */
    public function persist(Project $project): void
    {
        if (!$project->getId()) {
            $project->setCreatedBy($this->security->getUser());
        }
        $this->manager->persist($project);
        $this->manager->flush();
    }
    
    /**
     * @param  Project $project
     * @return void
     */
    public function delete(Project $project): void
    {
        $this->manager->remove($project);
        $this->manager->flush();
    }
}