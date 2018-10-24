<?php

use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\ReadModel\HardcodedIsUserBlocked;
use Infrastructure\Authentication\Repository\FilesystemUsers;
use Infrastructure\Authentication\Service\SendNotifyOfIntrusionDetectionToStderr;

require_once __DIR__ . '/../vendor/autoload.php';

$email = EmailAddress::fromEmailAddress($_POST['emailAddress']);
$password = ClearTextPassword::fromInputPassword($_POST['password']);

$users = new FilesystemUsers(__DIR__ . '/../data/users.json');

if (! $users->exists($email)) {
    echo 'Nope';

    return;
}

$user = $users->get($email);

$user->authenticate($password, new HardcodedIsUserBlocked(), new SendNotifyOfIntrusionDetectionToStderr());

echo 'OK';

