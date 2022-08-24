<?php

namespace Views\Cmd;

use App\Controller\RoomsController;
use App\Service\RoomService;

class RoomsShow extends BaseShow
{
    protected $roomsController;

    public function __construct()
    {
        $this->roomController = new RoomsController();
    }

    public function showAllRooms($rooms)
    {
        foreach ($rooms as $room) {
            echo " [Room " . $room['id'] . "] ";
        }
    }

    public function showRoomList()
    {
        $this->showMessage("Rooms list:\n");

        $rooms = $this->roomController->getAllRooms();
        $this->showAllRooms($rooms);
        $this->reserveRoom();
    }

    public function reserveRoom()
    {
        $roomNumber = (int) $this->showMessage("Input room number to reserve: (e.g 2)", true);
        $roomInfo = $this->roomController->getRoomInfo($roomNumber);
        $reserveInfo = null;
        if ($roomInfo) {
            $reserveInfo = $this->getReserveInfo($roomNumber);
            $this->roomController->reserveRoom($reserveInfo);
        } else {
            $this->showMessage("This room doesn't exist \n Choose existing room");
            $this->showRoomList();
        }

        $thankMessageForReserving = "[Room {$reserveInfo['roomId']} sucessfully reserved!!!]";
        $this->showMessage($thankMessageForReserving);
    }

    public function getReserveInfo(int $roomId): array
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
        return $reserveInfo;
    }
}
