<?php

namespace Domain\Shared\Exception;

final class ValidationException extends \Exception
{
    /** @var string[] */
    private array $errors;

    /** @param string[] $errors */
    public function __construct(array $errors)
    {
        parent::__construct('validation.failed');

        $this->errors = $errors;
    }

    /** @return string[] */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
