<?php

namespace App\Controller;

use App\Service\RoomService;

class RoomsController
{
    protected $roomService;

    public function __construct()
    {
        $this->roomService = new RoomService();
    }

    public function getAllRooms(): array
    {
        return $this->roomService->getAllRoomIds();
    }

    public function reserveRoom(array $reserveData)
    {
        $this->roomService->reserveRoom($reserveData);
    }

    public function getRoomInfo(int $roomId)
    {
        return $this->roomService->getRoomInfo($roomId);
    }
}
