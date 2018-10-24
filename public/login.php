<?php

use Authentication\Aggregate\User;
use Authentication\Value\ClearTextPassword;
use Authentication\Value\EmailAddress;
use Infrastructure\Authentication\ReadModel\HardcodedIsUserBlocked;
use Infrastructure\Authentication\Repository\DoctrineUsers;
use Infrastructure\Authentication\Service\SendNotifyOfIntrusionDetectionToStderr;

require_once __DIR__ . '/../vendor/autoload.php';

$email = EmailAddress::fromEmailAddress($_POST['emailAddress']);
$password = ClearTextPassword::fromInputPassword($_POST['password']);

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$users = new DoctrineUsers($entityManager, $entityManager->getRepository(User::class));

if (! $users->exists($email)) {
    echo 'Nope';

    return;
}

$user = $users->get($email);

$user->authenticate($password, new HardcodedIsUserBlocked(), new SendNotifyOfIntrusionDetectionToStderr());

echo 'OK';

