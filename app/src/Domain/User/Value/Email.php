<?php

declare(strict_types=1);

namespace Domain\User\Value;

use Domain\Shared\Error\ValidationException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'validation.email.required';
        } elseif (!preg_match('/^\S+@\S+\.\S+$/', $email)) {
            $errors['email'] = 'validation.email.invalid';
        }

        if (count($errors)) {
            throw new ValidationException($errors);
        }

        $this->email = $email;
    }

    public function getValue(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
