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
        return $this->db->queryExecute("SELECT * FROM rooms");
    }
}