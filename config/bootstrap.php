<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration([(__DIR__."/src")], $isDevMode);

$connection = [
    "dbname" => "movies",
    "user" => "root",
    "password" => "",
    "host" => "localhost",
    "driver" => "pdo_mysql"
];


$entityManager = EntityManager::create($connection, $config);

