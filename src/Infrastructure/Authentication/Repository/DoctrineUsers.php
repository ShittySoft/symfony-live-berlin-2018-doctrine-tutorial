<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Repository;

use Authentication\Aggregate\User;
use Authentication\Repository\Users;
use Authentication\Value\EmailAddress;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class DoctrineUsers implements Users
{
    /** @var ObjectRepository */
    private $repository;

    /** @var ObjectManager */
    private $objectManager;

    public function __construct(ObjectManager $objectManager, ObjectRepository $repository)
    {
        $this->objectManager = $objectManager;
        $this->repository    = $repository;
    }

    public function exists(EmailAddress $emailAddress) : bool
    {
        return (bool) $this->repository->find($emailAddress);
    }

    public function get(EmailAddress $emailAddress) : User
    {
        $user = $this->repository->find($emailAddress);

        if (! $user instanceof User) {
            throw new \RuntimeException(sprintf(
                'User %s does not exist',
                $emailAddress->toString()
            ));
        }

        return $user;
    }

    public function store(User $user) : void
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}
