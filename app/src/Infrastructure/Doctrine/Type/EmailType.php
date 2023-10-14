<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Domain\User\Value\Email;

class EmailType extends Type
{
    public const MYTYPE = 'email_type';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL(\array_merge($fieldDeclaration));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        if (null === $value) {
            return null;
        }

        return new Email($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof Email) {
            return $value->getValue();
        }

        return $value;
    }

    public function getName(): string
    {
        return self::MYTYPE;
    }
}
