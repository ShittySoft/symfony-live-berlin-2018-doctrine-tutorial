<?php

namespace Authentication\Entity;

use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Authentication\Value\PasswordHash;

class User
{
    /** @var EmailAddress */
    public $email;

    /** @var PasswordHash */
    public $passwordHash;

    public function __construct(EmailAddress $email, ClearTextPassword $password)
    {
        $this->email        = $email;
        $this->passwordHash = $password->makeHash();
    }

    public function authenticate(ClearTextPassword $password) : bool
    {
        return $password->verify($this->passwordHash);
    }
}
