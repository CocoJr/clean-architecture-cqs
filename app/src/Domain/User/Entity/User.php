<?php

namespace Domain\User\Entity;

class User
{
    private ?int $id = null;
    private string $username;
    private string $email;
    private string $password;
    /** @var string[] */
    private array $roles = ['ROLE_USER'];
    private ?\DateTime $createdAt = null;
    private ?\DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /** @return string[] */
    public function getRoles(): array
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

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);

        $this->password = $encryptedPassword;
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /** @param string[] $roles */
    public function setRoles(array $roles): void
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
