<?php

// registering a new user:

$email = $_POST['emailAddress'];
$password = $_POST['password'];

$existingUsers = json_decode(file_get_contents(__DIR__ . '/../data/users.json'), true);

if (isset($existingUsers[$email])) {
    echo 'Already registered';

    return;
}

$hash = password_hash($password, \PASSWORD_DEFAULT);

$existingUsers[$email] = $hash;

error_log('Registration mail sent here');

file_put_contents(__DIR__ . '/../data/users.json', json_encode($existingUsers));

echo 'OK';

