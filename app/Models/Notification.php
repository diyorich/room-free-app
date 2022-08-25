<?php

namespace App\Models;

use App\Lib\Database;

class Notification
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getReserveData(string $token)
    {
        $sql = "SELECT mail, room_id, r_from, r_to FROM room_schedules WHERE token = '{$token}'";
        return $this->db->queryExecute($sql);
    }
}