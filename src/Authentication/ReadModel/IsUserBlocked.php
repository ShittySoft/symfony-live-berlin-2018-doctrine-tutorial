<?php

namespace Authentication\ReadModel;

use Authentication\Value\EmailAddress;

interface IsUserBlocked
{
    public function __invoke(EmailAddress $emailAddress) : bool;
}
