<?php

namespace Authentication\Repository;

use Authentication\Entity\User;

interface Users
{
    public function exists(string $emailAddress) : bool;
    public function get(string $emailAddress) : User;
    public function store(User $user) : void;
}
