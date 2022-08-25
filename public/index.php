#!/opt/homebrew/opt/php@8.0/bin/php
<?php
require_once '../vendor/autoload.php';
require_once '../config/config.php';

date_default_timezone_set('Asia/Tashkent');

//command line commands

try {
    if ($argc >= 2) {
        $commandLine = new \Views\commands\CommandLine();
        $commandLine->handleCommands($argc, $argv);
    }
} catch (Exception $exception) {
    echo 'internal error occured';
}

