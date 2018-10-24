<?php

use Authentication\Value\EmailAddress;
use Authentication\Value\PasswordHash;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Proxy\ProxyFactory;
use Infrastructure\Authentication\DBAL\Type\EmailAddressType;
use Infrastructure\Authentication\DBAL\Type\PasswordHashType;

require_once __DIR__ . '/vendor/autoload.php';

$configuration = new Configuration();

// We use annotations for loading the entities in our system
$configuration->setMetadataDriverImpl(new XmlDriver(__DIR__ . '/mapping'));

// This is needed for Doctrine to generate files required for lazy-loading
$configuration->setProxyDir(sys_get_temp_dir());
$configuration->setProxyNamespace('ProxyExample');

// We are telling Doctrine to always generate files required for lazy-loading. This is a slow operation,
// and shouldn't be done in a production environment.
$configuration->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_EVAL);

Type::addType(EmailAddress::class, EmailAddressType::class);
Type::addType(PasswordHash::class, PasswordHashType::class);

// Finally creating the EntityManager: our entry point for the ORM
return EntityManager::create(
    [
        'driverClass' => Driver::class,
        'path'        => __DIR__ . '/data/test-db.sqlite',
    ],
    $configuration
);
