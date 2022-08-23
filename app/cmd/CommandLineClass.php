<?php

namespace App\cmd;

use App\Service\RoomService;
use Views\Cmd\RoomsShow;

class CommandLineClass implements UserInterface
{
    protected $roomService;

    public function __construct()
    {
        $this->roomService = new RoomService();
    }

    public function startDialog()
    {
        $message = "Welcome to room reserver app \n Press Enter to continue";
        $response = $this->showMessage($message, true);

        $this->showAvailableRooms();
    }

    public function stopDialog()
    {
        exit;
        // TODO: Implement exit() method.
    }

    protected function showMessage(string $message, $waitForResponse=false)
    {
        echo "\n______________________________\n";
        echo "$message \n";
        if ($waitForResponse) {
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            $response = trim($line);
            fclose($handle);
            return $response;
        }
    }

    protected function showAvailableRooms()
    {
        $this->showMessage("Rooms list:\n");
        $roomShow = new RoomsShow();

        $rooms = $this->roomService->getAllRoomIds();
        $roomShow->showAllRooms($rooms);

        $roomNumber = (int) $this->showMessage("Input room number to reserve: (e.g 2)", true);
        $roomExist = $this->roomService->checkIfRoomExist($roomNumber);

        if ($roomExist) {
            $this->checkRoomIsFree($roomNumber);
        } else {
            $this->showMessage("This room doesn't exist \n Choose existing room");
            $this->showAvailableRooms();
        }
    }

    protected function checkRoomIsFree(int $roomId)
    {
        //TODO add validations if time and weekday are existing and allowed from 10.00 to 18.00 only for example
        $message = "Application checks if room is available for requested date. \nPlease enter date to reserve room (e.g 2022-08-24)";
        $date = $this->showMessage($message, true);

        $timeMessage = "Enter time when you gonna reserve it (e.g. 14:00 or 01:00)";
        $timeStartReserve = $this->showMessage($timeMessage, true);

        $durationMessage = "Enter duration of your reserve in HOURS (e.g 2)";
        $reserveDuration = $this->showMessage($durationMessage, true);

        $mailMessage = "Enter mail of reserver (e.g example@gmail.com)";
        $mail = $this->showMessage($mailMessage, true);

        $reserveInfo = [
            'date' => $date,
            'timeStart' => $timeStartReserve,
            'reserveDuration' => $reserveDuration,
            'roomId' => $roomId,
            'reserverMail' => $mail
        ];

        $allowedToReserveRoom = $this->roomService->checkIfRoomIsFreeForRequestedTime($reserveInfo);

        if ($allowedToReserveRoom) {
            $this->roomService->reserverRoom($reserveInfo);
        } else {
            $message = "Room is not allowed to reserve cause it is busy";
            $this->showMessage($message);
        }
    }
}
