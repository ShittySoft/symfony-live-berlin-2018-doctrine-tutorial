<?php

use Authentication\Aggregate\User;
use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\ReadModel\CheckRegisteredEmailFromRepository;
use Infrastructure\Authentication\Repository\FilesystemUsers;

require_once __DIR__ . '/../vendor/autoload.php';

$email = EmailAddress::fromEmailAddress($_POST['emailAddress']);
$password = ClearTextPassword::fromInputPassword($_POST['password']);

$users = new FilesystemUsers(__DIR__ . '/../data/users.json');

$users->store(User::register($email, $password, new CheckRegisteredEmailFromRepository($users)));

/** @var Notifier $notify */
// send email abstraction?
//error_log('Registration mail sent here');

echo 'OK';

