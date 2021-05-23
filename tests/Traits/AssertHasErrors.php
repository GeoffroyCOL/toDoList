<?php

namespace App\Tests\Traits;

trait AssertHasErrors
{
    /**
     * assertHasErrors
     * Permet de vérifie les contraintes de validation d'une entité.
     *
     * @param mixed $entity
     */
    public function assertHasErrors($entity, int $number = 0): void
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($entity);
        $messages = [];

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }

        $this->assertCount($number, $errors, implode(', ', $messages));
    }
}
