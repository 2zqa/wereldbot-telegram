<?php

require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

telegram()->addCommands([
    Wereldbot\Commands\StatusCommand::class,
]);
