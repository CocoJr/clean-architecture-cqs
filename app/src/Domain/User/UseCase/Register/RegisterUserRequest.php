<?php

namespace Domain\User\UseCase\Register;

use Domain\Shared\Exception\ValidationException;

final readonly class RegisterUserRequest
{
    public function __construct(
        public string $username,
        public string $email,
        public string $password
    ) {
        $errors = $this->validate();

        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }

    /** @return string[] */
    public function validate(): array
    {
        $errors = [];

        if (strlen($this->username) < 3 || strlen($this->username) > 20) {
            $errors['username'] = 'validation.username.length';
        }

        if (empty($this->email)) {
            $errors['email'] = 'validation.email.required';
        } elseif (!preg_match('/^\S+@\S+\.\S+$/', $this->email)) {
            $errors['email'] = 'validation.email.invalid';
        }

        if (strlen($this->password) < 4 || strlen($this->password) > 100) {
            $errors['password'] = 'validation.password.length';
        }

        return $errors;
    }
}
