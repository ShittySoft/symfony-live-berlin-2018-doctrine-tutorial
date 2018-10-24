<?php

use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\Repository\FilesystemUsers;

require_once __DIR__ . '/../vendor/autoload.php';

$email = EmailAddress::fromEmailAddress($_POST['emailAddress']);
$password = ClearTextPassword::fromInputPassword($_POST['password']);

$users = new FilesystemUsers(__DIR__ . '/../data/users.json');

if (! $users->exists($email)) {
    echo 'Nope';

    return;
}

$user = $users->get($email);

if (! $user->authenticate($password)) {
    echo 'Nope';

    return;
}

echo 'OK';

