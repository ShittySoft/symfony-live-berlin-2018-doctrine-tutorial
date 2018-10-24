<?php

use Authentication\Aggregate\User;
use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\ReadModel\CheckRegisteredEmailFromRepository;
use Infrastructure\Authentication\Repository\DoctrineUsers;

require_once __DIR__ . '/../vendor/autoload.php';

$email = EmailAddress::fromEmailAddress($_POST['emailAddress']);
$password = ClearTextPassword::fromInputPassword($_POST['password']);

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$users = new DoctrineUsers($entityManager, $entityManager->getRepository(User::class));

$users->store(User::register($email, $password, new CheckRegisteredEmailFromRepository($users)));

/** @var Notifier $notify */
// send email abstraction?
//error_log('Registration mail sent here');

echo 'OK';

