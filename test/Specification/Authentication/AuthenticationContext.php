<?php

declare(strict_types=1);

namespace Test\Specification\Authentication;

use Authentication\Aggregate\User;
use Authentication\ReadModel\EmailIsRegistered;
use Authentication\ReadModel\IsUserBlocked;
use Authentication\Service\NotifyOfIntrusionDetection;
use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

final class AuthenticationContext implements Context
{
    /** @var EmailIsRegistered|null */
    private $emailIsRegistered;

    /** @var User|null */
    private $user;

    /**
     * @Given /^there are no registered users$/
     */
    public function thereAreNoRegisteredUsers() : void
    {
        $this->emailIsRegistered = new class implements EmailIsRegistered
        {
            public function __invoke(EmailAddress $emailAddress) : bool
            {
                return false;
            }
        };
    }

    /**
     * @When /^a user registers with the website$/
     */
    public function aUserRegistersWithTheWebsite() : void
    {
        \assert(null !== $this->emailIsRegistered);

        $this->user = User::register(
            EmailAddress::fromEmailAddress('me@example.com'),
            ClearTextPassword::fromInputPassword('potato'),
            $this->emailIsRegistered
        );
    }

    /**
     * @Then /^the user can log into the website$/
     */
    public function theUserCanLogIntoTheWebsite() : void
    {
        \assert(null !== $this->user);

        $this->user->authenticate(
            ClearTextPassword::fromInputPassword('potato'),
            new class implements IsUserBlocked {
                public function __invoke(EmailAddress $emailAddress) : bool
                {
                    return false;
                }
            },
            new class implements NotifyOfIntrusionDetection {
                public function __invoke(EmailAddress $emailAddress) : void
                {
                }
            }
        );
    }

    /**
     * @Given /^there is a registered user$/
     */
    public function thereIsARegisteredUser() : void
    {
        throw new PendingException();
    }

    /**
     * @Then /^the user cannot log into the website with a non\-matching password$/
     */
    public function theUserCannotLogIntoTheWebsiteWithANonMatchingPassword() : void
    {
        throw new PendingException();
    }
}
