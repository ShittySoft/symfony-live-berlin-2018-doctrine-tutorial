<?php

declare(strict_types=1);

namespace Authentication\Value;

use Webmozart\Assert\Assert;

final class ClearTextPassword
{
    /** @var string*/
    private $clearTextPassword;

    private function __construct(string $clearTextPassword)
    {
        $this->clearTextPassword = $clearTextPassword;
    }

    public static function fromInputPassword(string $password) : self
    {
        Assert::notEmpty($password);

        return new self($password);
    }

    public function makeHash() : PasswordHash
    {
        $yesThisIsAHashReally = password_hash($this->clearTextPassword, \PASSWORD_DEFAULT);

        \assert(\is_string($yesThisIsAHashReally));

        return PasswordHash::fromHash($yesThisIsAHashReally);
    }

    public function verify(PasswordHash $hash) : bool
    {
        return password_verify($this->clearTextPassword, $hash->toString());
    }
}
