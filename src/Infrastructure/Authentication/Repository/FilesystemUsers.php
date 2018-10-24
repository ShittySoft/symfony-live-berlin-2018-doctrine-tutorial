<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;
use Authentication\Value\EmailAddress;
use Authentication\Value\PasswordHash;

final class FilesystemUsers implements Users
{
    /** @var string */
    private $usersPath;

    public function __construct(string $usersPath)
    {
        $this->usersPath = $usersPath;
    }

    public function exists(EmailAddress $emailAddress) : bool
    {
        return isset($this->existingUsers()[$emailAddress->toString()]);
    }

    public function get(EmailAddress $emailAddress) : User
    {
        $existingUsers = $this->existingUsers();

        if (! isset($existingUsers[$emailAddress->toString()])) {
            throw new \UnexpectedValueException(sprintf('User %s does not exist', $emailAddress->toString()));
        }

        /** @var User $user */
        $user = (new \ReflectionClass(User::class))->newInstanceWithoutConstructor();

        $user->email = $emailAddress;
        $user->passwordHash = PasswordHash::fromHash($existingUsers[$emailAddress->toString()]);

        return $user;
    }

    public function store(User $user) : void
    {
        $existingUsers = $this->existingUsers();

        $existingUsers[$user->email->toString()] = $user->passwordHash->toString();

        file_put_contents($this->usersPath, json_encode($existingUsers));
    }

    /** @return array<string, string> */
    private function existingUsers() : array
    {
        $fileContentsReallyReally = file_get_contents($this->usersPath);

        \assert(\is_string($fileContentsReallyReally));

        return json_decode($fileContentsReallyReally, true);
    }
}
