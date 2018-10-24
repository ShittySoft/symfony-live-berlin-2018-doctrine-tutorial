<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\DBAL\Type;

use Authentication\Value\PasswordHash;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class PasswordHashType extends StringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        \assert(is_string($value));

        return PasswordHash::fromHash($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        \assert($value instanceof PasswordHash);

        return parent::convertToDatabaseValue($value->toString(), $platform);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return PasswordHash::class;
    }
}
