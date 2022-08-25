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
        if ($argv[1] == '-room-list') {
            $roomsController = new \App\Controller\RoomsController();
            $allRooms = $roomsController->getAllRooms();
            $this->roomsShow->showAllRooms($allRooms);
        }

        if ($argc == 3 && $argv[1] == '-check-room') {
            $this->roomsShow->checkRoom($argv[2]);
        }

        if ($argc == 3 && $argv[1] == '-send-notification')
        {
            $this->roomsShow->sendNotification($argv[2]);
        }

        if ($argc == 2 && $argv[1] == '-setup-app')
        {
            echo "Setuping application";
            $migrations = new \App\lib\migrations\GeneralMigration();
            $migrations->prepareEnvironment();
        }

        if ($argc == 2 && $argv[1] == '-help')
        {

            echo "APPLICATION SETUP:\n" .
                "-setup-app      -Setups application\n\n\n" .
                "APPLICATION COMMANDS:\n" .
                "-room-list    -Shows rooms\n" .
                "-check-room [roomId]   -Check if room is free\n" .
                "-send-notification [token]  -send notification to user after reserving ";
        }
    }
}
