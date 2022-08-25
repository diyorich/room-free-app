<?php

namespace Views\commands;

use Views\Cmd\RoomsShow;

class CommandLine
{
    protected $roomsShow;

    public function __construct()
    {
        $this->roomsShow = new RoomsShow();
    }

    public function handleCommands($argc, $argv)
    {
        $roomsController = new \App\Controller\RoomsController();
        $allRooms = $roomsController->getAllRooms();

        if($argv[1] == '-room-list') {
            $allRooms = $roomsController->getAllRooms();
            $this->roomsShow->showAllRooms($allRooms);
        }

        if ($argc == 3 && $argv[1] == '-check-room') {
            $this->roomsShow->checkRoom($argv[2]);
        }

        if ($argc == 3 && $argv[1] == '-send-notification')
        {
            $roomsController->sendNotification($argv[2]);
        }
    }
}