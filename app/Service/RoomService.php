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

    public function getIntersectingRoomSchedule(array $reserveInfo)
    {
        $reserveStart = date('Y-m-d H:i', strtotime($reserveInfo['reserveStart']));
        $reserveEnd = date('Y-m-d H:i', strtotime($reserveInfo['reserveEnd']));

        $roomSchedules = $this->room->getSpecificRoomSchedules($reserveInfo['roomId']);

        foreach ($roomSchedules as $schedule) {
            $roomIsBusy = (strtotime($reserveStart) < strtotime($schedule['r_to']) && strtotime($schedule['r_from']) < strtotime($reserveEnd) ? true : false);
                if ($roomIsBusy) {
                    return [
                        "room_id" => $schedule['room_id'],
                        "reserved_by" => $schedule['reserved_by'],
                        "r_from" => $schedule['r_from'],
                        "r_to" => $schedule['r_to']
                    ];
                }
        }
    }

    public function reserveRoom(array $reserveInfo): string
    {
        //TODO add validation to max duration hours 10 hours
        //TODO validate date value
        $roomId = $reserveInfo['roomId'];
        $reserveStart = date('Y-m-d H:i', strtotime($reserveInfo['reserveStart']));
        $reserveEnd = date('Y-m-d H:i', strtotime($reserveInfo['reserveEnd']));
        $reservedBy = $reserveInfo['reservedBy'];
        $reserverMail = $reserveInfo['reserverMail'];
        //GENERATING TOKEN
        $token = $this->generateToken(20);

        $this->room->saveRoomReserve($roomId, $reserveStart, $reserveEnd, $reservedBy, $reserverMail , $token);

        return $token;
    }


    /** Checks if rooms is free to reserve. If not, returns message by person it was reserved by
     * @param array $reserveInfo
     * @return array|void
     */
    public function checkRoomIsFree(array $reserveInfo)
    {
        return $this->getIntersectingRoomSchedule($reserveInfo);
    }

    public function generateToken($length)
    {
        $allowedCharacters = '0123456789abcdefghijklmnopqrstuvwxyz';

        $token = '';
        $allowedCharactersLength = mb_strlen($allowedCharacters, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $token .= $allowedCharacters[random_int(0, $allowedCharactersLength)];
        }

        return $token;
    }
}
