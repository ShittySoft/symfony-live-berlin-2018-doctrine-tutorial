<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Repository;

use Authentication\Aggregate\User;
use Authentication\Repository\Users;
use Authentication\Value\EmailAddress;
use Authentication\Value\PasswordHash;
use ReflectionProperty;

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

        $this->reflectionEmail()->setValue($user, $emailAddress);
        $this->reflectionPasswordHash()->setValue($user, PasswordHash::fromHash($existingUsers[$emailAddress->toString()]));

        return $user;
    }

    public function store(User $user) : void
    {
        $existingUsers = $this->existingUsers();

        $existingUsers[
            $this->reflectionEmail()->getValue($user)->toString()
        ] = $this->reflectionPasswordHash()->getValue($user)->toString();

        file_put_contents($this->usersPath, json_encode($existingUsers));
    }

    /** @return array<string, string> */
    private function existingUsers() : array
    {
        $fileContentsReallyReally = file_get_contents($this->usersPath);

        \assert(\is_string($fileContentsReallyReally));

        return json_decode($fileContentsReallyReally, true);
    }

    private function reflectionEmail() : ReflectionProperty
    {
        $reflectionEmail = new ReflectionProperty(User::class, 'email');

        $reflectionEmail->setAccessible(true);

        return $reflectionEmail;
    }

    private function reflectionPasswordHash() : ReflectionProperty
    {
        $reflectionEmail = new ReflectionProperty(User::class, 'passwordHash');

        $reflectionEmail->setAccessible(true);

        return $reflectionEmail;
    }

}
