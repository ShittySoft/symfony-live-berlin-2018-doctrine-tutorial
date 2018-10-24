<?php

declare(strict_types=1);

namespace Authentication\Value;

final class EmailAddress
{
    /** @var string */
    private $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function fromEmailAddress(string $emailAddress) : self
    {
        if (! filter_var($emailAddress, \FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf(
                '%s is not a valid %s',
                $emailAddress,
                self::class
            ));
        }

        return new self($emailAddress);
    }

    public function toString() : string
    {
        return $this->email;
    }

    public function __toString() : string
    {
        return $this->email;
    }
}
