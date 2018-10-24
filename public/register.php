<?php

require_once __DIR__ . '/../vendor/autoload.php';

$email = $_POST['emailAddress'];
$password = $_POST['password'];

$users = new \Infrastructure\Authentication\Repository\FilesystemUsers(__DIR__ . '/../data/users.json');

if ($users->exists($email)) {
    echo 'Already registered';

    return;
}

$user = new \Authentication\Entity\User(
    $email,
    $password
);

$users->store($user);

/** @var Notifier $notify */
// send email abstraction?
//error_log('Registration mail sent here');

echo 'OK';

