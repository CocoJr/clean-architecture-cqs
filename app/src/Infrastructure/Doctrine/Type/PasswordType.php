<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Domain\User\Value\Password;

class PasswordType extends Type
{
    public const MYTYPE = 'password_type';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getStringTypeDeclarationSQL(\array_merge($fieldDeclaration));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        return new Password($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Password) {
            return $value->getValue();
        }

        return $value;
    }

    public function getName()
    {
        return self::MYTYPE;
    }
}
