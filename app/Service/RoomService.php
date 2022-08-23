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

    /**
     * @param int $roomId meeting room id
     * @param string $weekDay meeting day
     * @param string $start meeting start
     * @param int $duration meeting duration
     * @return array
     */
    public function checkIfRoomScheduleIsFree(int $roomId, string $weekDay, string $start, int $duration): array
    {
        return $this->room->getRoomSchedule($roomId, $weekDay, );
    }

    public function checkIfRoomExist(int $roomId): bool
    {
        return (bool) $this->room->getRoomById($roomId);
    }

    public function checkIfRoomIsFreeForRequestedTime(array $reserveInfo): bool|array
    {
        //TODO checking if room is busy for given time
        return true;
    }

    public function reserverRoom(array $reserveInfo)
    {
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
        $mailBody = "You received this mail because you received room #{$roomId} for date : {$reserveDate} ($reserveTime - $reservedFinishHours)";
        var_dump($reserverMail);
        $mailService = new MailService();
        $mailService->sendMail($reserverMail, $mailTitle,$mailBody);
    }
}
