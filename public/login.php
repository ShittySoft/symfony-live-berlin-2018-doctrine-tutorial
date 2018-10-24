<?php

$user = $_POST['emailAddress'];
$password = $_POST['password'];

$existingUsers = json_decode(file_get_contents(__DIR__ . '/../data/users.json'), true);

if (!isset($existingUsers[$user])) {
    echo 'Nope';

    return;
}

if (! password_verify($password, $existingUsers[$user])) {
    echo 'Nope';

    return;
}

echo 'Ok';
