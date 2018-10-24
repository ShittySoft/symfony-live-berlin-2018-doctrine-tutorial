<?php

require_once __DIR__ . '/../vendor/autoload.php';

$email = $_POST['emailAddress'];
$password = $_POST['password'];

$users = new \Infrastructure\Authentication\Repository\FilesystemUsers(__DIR__ . '/../data/users.json');

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

