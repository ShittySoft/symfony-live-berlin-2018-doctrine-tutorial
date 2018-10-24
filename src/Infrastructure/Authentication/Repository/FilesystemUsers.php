<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;

final class FilesystemUsers implements Users
{
    /** @var string */
    private $usersPath;

    public function __construct(string $usersPath)
    {
        $this->usersPath = $usersPath;
    }

    public function exists(string $emailAddress) : bool
    {
        return isset($this->existingUsers()[$emailAddress]);
    }

    public function get(string $emailAddress) : User
    {
        $existingUsers = $this->existingUsers();

        if (! isset($existingUsers[$emailAddress])) {
            throw new \UnexpectedValueException(sprintf('User %s does not exist', $emailAddress));
        }

        $user = (new \ReflectionClass(User::class))->newInstanceWithoutConstructor();

        $user->email = $emailAddress;
        $user->passwordHash = $existingUsers[$emailAddress];

        return $user;
    }

    public function store(User $user) : void
    {
        $existingUsers = $this->existingUsers();

        $existingUsers[$user->email] = $user->passwordHash;

        file_put_contents($this->usersPath, json_encode($existingUsers));
    }

    /** @return array<string, string> */
    private function existingUsers() : array
    {
        return json_decode(file_get_contents($this->usersPath), true);
    }
}
