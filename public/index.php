#!/opt/homebrew/opt/php@8.0/bin/php
<?php
require_once '../vendor/autoload.php';
require_once '../config/config.php';

date_default_timezone_set('Asia/Tashkent');

//command line commands

$commandLine = new \Views\commands\CommandLine();
if ($argc > 2) {
    $commandLine->handleCommands($argc, $argv);
}

