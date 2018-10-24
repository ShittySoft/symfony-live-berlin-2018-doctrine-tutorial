<?php

namespace Authentication\Entity;

class User
{
    /** @var string */
    public $email;

    /** @var string */
    public $passwordHash;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->passwordHash = password_hash($password, \PASSWORD_DEFAULT);
    }

    public function authenticate(string $password) : bool
    {
        return password_verify($password, $this->passwordHash);
    }
}
