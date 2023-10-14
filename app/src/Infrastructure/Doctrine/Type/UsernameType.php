<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Domain\User\Value\Username;

class UsernameType extends Type
{
    public const MYTYPE = 'username_type';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL(\array_merge($fieldDeclaration));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Username
    {
        if (null === $value) {
            return null;
        }

        return new Username($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof Username) {
            return $value->getValue();
        }

        return $value;
    }

    public function getName(): string
    {
        return self::MYTYPE;
    }
}
