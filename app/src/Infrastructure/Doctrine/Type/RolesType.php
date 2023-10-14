<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Domain\User\Value\Role;
use Domain\User\Value\Roles;

class RolesType extends Type
{
    public const MYTYPE = 'roles_type';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getBlobTypeDeclarationSQL(\array_merge($fieldDeclaration));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Roles
    {
        if (null === $value) {
            return null;
        }

        $roles = [];

        foreach ($value as $roleName) {
            $roles[] = new Role($roleName);
        }

        return new Roles(...$roles);
    }

    /** @return iterable<string> */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): iterable
    {
        if ($value instanceof Roles) {
            return $value->getValue();
        }

        return $value;
    }

    public function getName(): string
    {
        return self::MYTYPE;
    }
}
