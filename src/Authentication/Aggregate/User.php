<?php

namespace Authentication\Aggregate;

use Authentication\ReadModel\EmailIsRegistered;
use Authentication\ReadModel\IsUserBlocked;
use Authentication\Service\NotifyOfIntrusionDetection;
use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Authentication\Value\PasswordHash;
use Webmozart\Assert\Assert;

class User
{
    /** @var EmailAddress */
    private $email;

    /** @var PasswordHash */
    private $passwordHash;

    private function __construct(EmailAddress $email, ClearTextPassword $password)
    {
        $this->email        = $email;
        $this->passwordHash = $password->makeHash();
    }

    public static function register(
        EmailAddress $email,
        ClearTextPassword $password,
        EmailIsRegistered $emailIsRegistered
    ) : self {
        Assert::false($emailIsRegistered->__invoke($email));

        return new self($email, $password);
    }

    public function authenticate(
        ClearTextPassword $password,
        IsUserBlocked $blockedUsers,
        NotifyOfIntrusionDetection $intrusionDetection
    ) : void {
        Assert::true($password->verify($this->passwordHash));

        if ($blockedUsers->__invoke($this->email)) {
            $intrusionDetection->__invoke($this->email);

            throw new \RuntimeException(sprintf(
                'User %s is blocked, and cannot authenticate',
                $this->email->toString()
            ));
        }
    }
}
