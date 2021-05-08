#!/bin/php
<?php

// Get user input
$botToken = readline("Enter your telegram bot token: ");
$exposeSubdomain = readline("(Optional) Enter expose subdomain: ");
if (!$exposeSubdomain) {
    $webhookUrl = readline("Enter webhook url: ");
} else {
    $webhookUrl = "https://" . $exposeSubdomain . ".sharedwithexpose.com/webhook.php";
}

// Write .env
if ($botToken || $webhookUrl) {
    $handle = @fopen(".env", "w");
    if (!$handle) {
        die("Couldn't write to .env");
    }
    if ($botToken) {
        fwrite($handle, "TELEGRAM_BOT_TOKEN=\"" . $botToken . "\"\n");
    }
    if ($webhookUrl) {
        fwrite($handle, "TELEGRAM_WEBHOOK=\"" . $webhookUrl . "\"\n");
    }
    fclose($handle);
} else {
    print("No token or url specified, skipping writing .env");
}

// Write composer.json
if ($exposeSubdomain) {
    $composerObject = json_decode(file_get_contents("composer.json.preset"));
    if (!$composerObject) {
        die("Couldn't read composer.json.preset");
    }
    // command runs a php webserver with the public-folder as root, and then exposes it to the internet using expose
    $devCommand = "php -S localhost:8080 -t public &>/dev/null & expose share localhost:8080 --subdomain=" . $exposeSubdomain;
    $composerObject->scripts->dev = $devCommand;

    $result = file_put_contents("composer.json", json_encode($composerObject, JSON_PRETTY_PRINT));
    if (!$result) {
        die("Couldn't write to composer.json.");
    }
} else {
    // Simply copy the preset file as-is
    copy("composer.json.preset", "composer.json");
}

// Run scripts
$runSetup = readline("\nWould you like to run composer install and setup.php [Y/n]: ");

if (strtolower($runSetup) != 'n') {
    // composer install
    print("Running composer install...");
    shell_exec("composer update");
    shell_exec("composer install");

    // setup.php
    require('setup.php');
}