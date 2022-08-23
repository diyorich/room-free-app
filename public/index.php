#!/opt/homebrew/opt/php@8.0/bin/php
<?php
require_once '../vendor/autoload.php';
require_once '../config/config.php';

//Starting dialog in terminal
$commandLine = new \App\cmd\CommandLineClass();
$commandLine->startDialog();
