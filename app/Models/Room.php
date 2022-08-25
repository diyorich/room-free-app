<?php

namespace App\Models;

use App\Lib\Database;

class Room
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllRooms(): array
    {
        return $this->db->queryExecute("SELECT id FROM rooms");
    }

    public function getRoomSchedule(int $roomId): array
    {
        $query = "SELECT * FROM rooms_schedule WHERE room_id = {$roomId}";
        return $this->db->queryExecute($query);
    }

    public function getRoomById(int $roomId): array
    {
        $query = "SELECT * FROM rooms WHERE ID = {$roomId}";
        return $this->db->queryExecute($query);
    }

    public function saveRoomReserve(int $roomId, string $r_from, string $r_to, string $reserved_by, string $mail, string $token): void
    {
        $query = "INSERT INTO room_schedules(room_id, r_from, r_to, reserved_by, mail, token)
                   VALUES({$roomId}, '{$r_from}', '{$r_to}', '{$reserved_by}', '{$mail}', '{$token}')";

        $this->db->query($query);
    }

    public function getSpecificRoomSchedules(int $roomId)
    {
        $query = "SELECT * FROM room_schedules
                  WHERE room_id = {$roomId}";

        return $this->db->queryExecute($query);
    }
}
