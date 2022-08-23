<?php

namespace Views\Cmd;

use App\Service\RoomService;

class RoomsShow
{
    protected $roomService;

    public function __construct()
    {
        $this->roomService = new RoomService();
    }

    public function showAllRooms(array $rooms)
    {
        foreach ($rooms as $room) {
            echo " [Room " . $room['id'] . "] ";
        }
    }
}