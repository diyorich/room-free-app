<?php

namespace App\Controller;

use App\Service\NotificationService;
use App\Service\RoomService;

class RoomsController
{
    protected $roomService;

    protected $notificationService;

    public function __construct()
    {
        $this->roomService = new RoomService();
        $this->notificationService = new NotificationService();
    }

    public function getAllRooms(): array
    {
        return $this->roomService->getAllRoomIds();
    }

    public function reserveRoom(array $reserveData)
    {
        return $this->roomService->reserveRoom($reserveData);
    }

    public function checkRoomIsFree(array $reserveInfo)
    {
        return $this->roomService->checkRoomIsFree($reserveInfo);
    }
}
