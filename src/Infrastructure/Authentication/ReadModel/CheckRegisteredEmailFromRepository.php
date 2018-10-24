<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\ReadModel;

use Authentication\ReadModel\EmailIsRegistered;
use Authentication\Repository\Users;
use Authentication\Value\EmailAddress;

final class CheckRegisteredEmailFromRepository implements EmailIsRegistered
{
    /** @var Users */
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function __invoke(EmailAddress $emailAddress) : bool
    {
        return $this->users->exists($emailAddress);
    }
}
