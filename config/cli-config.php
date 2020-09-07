<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
require $_SERVER["DOCUMENT_ROOT"] . "/config/bootstrap.php";

return ConsoleRunner::createHelperSet($entityManager);
