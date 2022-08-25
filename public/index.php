#!/opt/homebrew/opt/php@8.0/bin/php
<?php
require_once '../vendor/autoload.php';
require_once '../config/config.php';

date_default_timezone_set('Asia/Tashkent');

//Starting application in terminal
//$app = new \Views\FrontTerminalApplication();
//$app->start();

//command line commands

$commandLine = new \Views\commands\CommandLine();
$commandLine->handleCommands($argc, $argv);

//./index.php -see-rooms
//if ($argc == 1 || $argv[1] == '-show') {
//    $roomsController = new \App\Controller\RoomsController();
//    $allRooms = $roomsController->getAllRooms();
//    $rooms = new \Views\Cmd\RoomsShow();
//    $rooms->showAllRooms($allRooms);
//}
//
//if($argc == 5 && $argv[1] == '-reserve') {
//    $roomId = $argv[2];
//    $reserveDate = $argv[3];
//    $duration = $argv[4];
//
//    var_dump($roomId, $reserveDate, $duration);

