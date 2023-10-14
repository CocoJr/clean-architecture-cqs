<?php

namespace Domain\User\Model;

use Domain\User\Value\Email;
use Domain\User\Value\Password;
use Domain\User\Value\Roles;
use Domain\User\Value\Username;

class User
{
    private ?int $id = null;
    private Username $username;
    private Email $email;
    private Password $plainPassword;
    private string $password;
    private Roles $roles;
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPlainPassword(): Password
    {
        return $this->plainPassword;
    }

    public function getRoles(): Roles
    {
        return $this->roles;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUsername(Username $username): void
    {
        $this->username = $username;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function checkPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function setPlainPassword(Password $password): void
    {
        $this->plainPassword = $password;
        $encryptedPassword = password_hash($password->getValue(), PASSWORD_BCRYPT);

        $this->password = $encryptedPassword;
    }

    public function setRoles(Roles $roles): void
    {
        $this->roles = $roles;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
