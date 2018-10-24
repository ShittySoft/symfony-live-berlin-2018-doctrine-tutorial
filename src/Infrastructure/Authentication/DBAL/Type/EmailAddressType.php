<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\DBAL\Type;

use Authentication\Value\EmailAddress;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class EmailAddressType extends StringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        \assert(is_string($value));

        return EmailAddress::fromEmailAddress($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        \assert($value instanceof EmailAddress);

        return parent::convertToDatabaseValue($value->toString(), $platform);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return EmailAddress::class;
    }
}
