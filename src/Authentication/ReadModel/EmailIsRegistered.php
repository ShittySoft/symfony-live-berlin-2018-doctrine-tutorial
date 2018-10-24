<?php

namespace Authentication\ReadModel;

use Authentication\Value\EmailAddress;

interface EmailIsRegistered
{
    public function __invoke(EmailAddress $emailAddress) : bool;
}
