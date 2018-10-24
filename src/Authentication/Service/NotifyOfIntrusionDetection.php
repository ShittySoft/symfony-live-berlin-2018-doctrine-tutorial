<?php

namespace Authentication\Service;

use Authentication\Value\EmailAddress;

interface NotifyOfIntrusionDetection
{
    public function __invoke(EmailAddress $emailAddress) : void;
}
