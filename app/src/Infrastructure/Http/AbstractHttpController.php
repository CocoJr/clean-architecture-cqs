<?php

namespace Infrastructure\Http;

use Domain\Shared\Error\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractHttpController extends AbstractController
{
    /**
     * @param array<string> $errors
     */
    protected function validateField(string $value, string $class, array &$errors): ?object
    {
        try {
            return new $class($value);
        } catch (ValidationException $e) {
            $errors += $e->getErrors();

            return null;
        }
    }
}
