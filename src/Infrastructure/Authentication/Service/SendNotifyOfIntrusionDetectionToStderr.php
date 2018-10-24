<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Service;

use Authentication\Service\NotifyOfIntrusionDetection;
use Authentication\Value\EmailAddress;

final class SendNotifyOfIntrusionDetectionToStderr implements NotifyOfIntrusionDetection
{
    public function __invoke(EmailAddress $emailAddress) : void
    {
        error_log(sprintf(
            'Intrusion detected: unauthorised user %s',
            $emailAddress->toString()
        ));
    }
}
