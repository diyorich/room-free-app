#!/opt/homebrew/opt/php@8.0/bin/php
<?php
require_once '../vendor/autoload.php';
require_once '../config/config.php';

//Starting application in terminal
$app = new \Views\FrontTerminalApplication();
$app->start();
