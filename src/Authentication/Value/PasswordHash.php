<?php

declare(strict_types=1);

namespace Authentication\Value;

use Webmozart\Assert\Assert;

final class PasswordHash
{
    /** @var string */
    private $hash;

    private function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public static function fromHash(string $hash) : self
    {
        Assert::startsWith($hash, '$');

        return new self($hash);
    }

    public function toString() : string
    {
        return $this->hash;
    }
}
