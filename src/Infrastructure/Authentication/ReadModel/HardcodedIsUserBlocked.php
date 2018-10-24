<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\ReadModel;

use Authentication\ReadModel\IsUserBlocked;
use Authentication\Value\EmailAddress;

final class HardcodedIsUserBlocked implements IsUserBlocked
{
    public function __invoke(EmailAddress $emailAddress) : bool
    {
        return $emailAddress->toString() === 'trump@whitehouse.gov';
    }
}
