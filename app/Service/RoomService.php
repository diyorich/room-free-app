<?php

namespace App\Service;

use App\Models\Room;
use App\Service\Remote\MailService;

class RoomService
{
    protected $room;

    public function __construct()
    {
        $this->room = new Room();
    }

    public function getAllRoomIds(): array
    {
        return $this->room->getAllRooms();
    }

    public function getRoomInfo(int $roomId): array
    {
        return $this->room->getRoomById($roomId);
    }

    public function checkIfRoomIsFreeForRequestedTime(array $reserveInfo): bool|array
    {
        //TODO checking if room is busy for given time logic must be implemented
        return true;
    }

    public function reserveRoom(array $reserveInfo)
    {
        //Some kind of room free validation
        $this->checkIfRoomIsFreeForRequestedTime($reserveInfo);


        //TODO add validation to max duration hours 10 hours
        //TODO validate date value
        $roomId = $reserveInfo['roomId'];
        $reserveDate = $reserveInfo['date'];
        $reserveTime = $reserveInfo['timeStart'];

        $reserveDuration = (int) $reserveInfo['reserveDuration'];
        $reservedDateAndTime = date($reserveDate . ' ' . $reserveTime);
        $reservedTimeInSeconds = strtotime($reservedDateAndTime . "+{$reserveDuration} hours");

        $reservedFinishHours = date('H:i', $reservedTimeInSeconds);
        $reservedBy = 1;

        $this->room->saveRoomReserve($roomId, $reserveDate, $reserveTime, $reservedFinishHours, $reservedBy);

        $reserverMail = $reserveInfo['reserverMail'];
        $mailTitle = "Room #{$roomId} reserved";
        $mailBody = "You received this mail because you reserved room #{$roomId} for date : {$reserveDate} ($reserveTime - $reservedFinishHours)";
        $mailService = new MailService();
        $mailService->sendMail($reserverMail, $mailTitle,$mailBody);
    }
}
